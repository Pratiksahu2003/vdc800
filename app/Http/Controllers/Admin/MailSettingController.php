<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\MailConfigService;
use App\Services\SiteSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.mail', [
            'mail' => SiteSetting::instance(),
        ]);
    }

    public function update(Request $request, SiteSettingsService $settings)
    {
        $validated = $request->validate([
            'mail_mailer' => 'required|in:smtp,log',
            'mail_host' => 'nullable|required_if:mail_mailer,smtp|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:500',
            'mail_encryption' => 'nullable|in:tls,ssl,none',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'mail_ehlo_domain' => 'nullable|string|max:255',
        ]);

        if (($validated['mail_encryption'] ?? '') === 'none') {
            $validated['mail_encryption'] = null;
        }

        $site = SiteSetting::instance();

        if (blank($validated['mail_password'] ?? null)) {
            unset($validated['mail_password']);
        }

        $site->update($validated);
        $settings->clearCache();
        MailConfigService::applyFromDatabase();

        return back()->with('success', 'Email / SMTP settings saved successfully.');
    }

    public function sendTest(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email|max:255',
        ]);

        MailConfigService::applyFromDatabase();

        try {
            Mail::raw(
                'This is a test message from '.config('app.name').'. SMTP settings from the admin panel are working.',
                function ($message) use ($request) {
                    $message->to($request->input('test_email'))
                        ->subject('SMTP test — '.config('app.name'));
                },
            );
        } catch (\Throwable $exception) {
            return back()->with('error', 'Test email failed: '.$exception->getMessage());
        }

        return back()->with('success', 'Test email sent to '.$request->input('test_email').'.');
    }
}
