<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class MailConfigService
{
    public static function applyFromDatabase(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        try {
            $site = SiteSetting::instance();

            $mailer = $site->mail_mailer ?: (filled($site->mail_host) ? 'smtp' : null);
            if ($mailer === null) {
                return;
            }

            Config::set('mail.default', $mailer);

            if ($mailer === 'log') {
                self::applyFromAddress($site);

                return;
            }

            if ($mailer === 'smtp' && filled($site->mail_host)) {
                Config::set('mail.mailers.smtp.host', $site->mail_host);
                Config::set('mail.mailers.smtp.port', (int) ($site->mail_port ?: 587));
                Config::set('mail.mailers.smtp.username', $site->mail_username);
                Config::set('mail.mailers.smtp.password', $site->mail_password);
                Config::set('mail.mailers.smtp.scheme', self::schemeForEncryption($site->mail_encryption));

                if (filled($site->mail_ehlo_domain)) {
                    Config::set('mail.mailers.smtp.local_domain', $site->mail_ehlo_domain);
                }
            }

            self::applyFromAddress($site);
        } catch (\Throwable) {
            return;
        }
    }

    private static function applyFromAddress(SiteSetting $site): void
    {
        if (filled($site->mail_from_address)) {
            Config::set('mail.from.address', $site->mail_from_address);
        }

        if (filled($site->mail_from_name)) {
            Config::set('mail.from.name', $site->mail_from_name);
        }
    }

    private static function schemeForEncryption(?string $encryption): ?string
    {
        return match ($encryption) {
            'ssl' => 'smtps',
            'tls' => 'smtp',
            default => 'smtp',
        };
    }
}
