<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('mail_mailer')->nullable()->after('og_image');
            $table->string('mail_host')->nullable()->after('mail_mailer');
            $table->unsignedSmallInteger('mail_port')->nullable()->after('mail_host');
            $table->string('mail_username')->nullable()->after('mail_port');
            $table->text('mail_password')->nullable()->after('mail_username');
            $table->string('mail_encryption')->nullable()->after('mail_password');
            $table->string('mail_from_address')->nullable()->after('mail_encryption');
            $table->string('mail_from_name')->nullable()->after('mail_from_address');
            $table->string('mail_ehlo_domain')->nullable()->after('mail_from_name');
        });

        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $row = DB::table('site_settings')->first();
        if (! $row) {
            return;
        }

        $password = env('MAIL_PASSWORD');
        DB::table('site_settings')->where('id', $row->id)->update([
            'mail_mailer' => env('MAIL_MAILER', 'smtp'),
            'mail_host' => env('MAIL_HOST'),
            'mail_port' => (int) env('MAIL_PORT', 587) ?: null,
            'mail_username' => env('MAIL_USERNAME'),
            'mail_password' => filled($password) ? Crypt::encryptString($password) : null,
            'mail_encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'mail_from_address' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'mail_ehlo_domain' => env('MAIL_EHLO_DOMAIN'),
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'mail_mailer',
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
                'mail_encryption',
                'mail_from_address',
                'mail_from_name',
                'mail_ehlo_domain',
            ]);
        });
    }
};
