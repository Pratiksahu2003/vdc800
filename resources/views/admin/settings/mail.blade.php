@extends('layouts.admin')

@section('title', 'Email & SMTP')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Email & SMTP</h1>
        <p class="text-sm text-brand-500 mt-1">Configure outbound mail for contact form notifications and system messages. Settings here override <code class="text-brand-700">.env</code> when SMTP host is set.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.mail') }}" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="mail_mailer" class="block text-sm font-medium text-brand-800 mb-1.5">Mail driver</label>
                <select id="mail_mailer" name="mail_mailer" class="w-full rounded-lg border border-brand-200 px-3 py-2.5 text-sm text-brand-900 focus:border-brand-teal-500 focus:ring-brand-teal-500">
                    <option value="smtp" @selected(old('mail_mailer', $mail->mail_mailer ?? 'smtp') === 'smtp')>SMTP (live delivery)</option>
                    <option value="log" @selected(old('mail_mailer', $mail->mail_mailer) === 'log')>Log only (testing)</option>
                </select>
            </div>
            @include('admin.components.input', ['name' => 'mail_host', 'label' => 'SMTP host', 'value' => old('mail_host', $mail->mail_host), 'placeholder' => 'smtp-relay.brevo.com'])
            @include('admin.components.input', ['name' => 'mail_port', 'label' => 'Port', 'type' => 'number', 'value' => old('mail_port', $mail->mail_port ?? 587)])
            @include('admin.components.input', ['name' => 'mail_username', 'label' => 'SMTP login / username', 'value' => old('mail_username', $mail->mail_username)])
            @include('admin.components.input', ['name' => 'mail_password', 'label' => 'SMTP password / API key', 'type' => 'password', 'value' => '', 'placeholder' => $mail->mail_password ? '•••••••• (leave blank to keep current)' : 'Enter SMTP key'])
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="mail_encryption" class="block text-sm font-medium text-brand-800 mb-1.5">Encryption</label>
                <select id="mail_encryption" name="mail_encryption" class="w-full rounded-lg border border-brand-200 px-3 py-2.5 text-sm text-brand-900 focus:border-brand-teal-500 focus:ring-brand-teal-500">
                    @php $enc = old('mail_encryption', $mail->mail_encryption ?? 'tls'); @endphp
                    <option value="tls" @selected($enc === 'tls')>TLS (port 587)</option>
                    <option value="ssl" @selected($enc === 'ssl')>SSL (port 465)</option>
                    <option value="none" @selected($enc === null || $enc === 'none')>None</option>
                </select>
            </div>
            @include('admin.components.input', ['name' => 'mail_ehlo_domain', 'label' => 'Sending domain (EHLO)', 'value' => old('mail_ehlo_domain', $mail->mail_ehlo_domain), 'placeholder' => 'd3.vedmint.online'])
            <p class="text-xs text-brand-500 md:col-span-2 -mt-2">Use your domain name only (not an email address). Form notifications are configured under <strong>Company Settings → Form notification email(s)</strong>, not here.</p>
        </div>

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">From address</h3>
        <p class="text-xs text-brand-500 -mt-2">Must match a sender verified with your email provider (e.g. Brevo).</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'mail_from_address', 'label' => 'From email', 'type' => 'email', 'value' => old('mail_from_address', $mail->mail_from_address)])
            @include('admin.components.input', ['name' => 'mail_from_name', 'label' => 'From name', 'value' => old('mail_from_name', $mail->mail_from_name ?? settings('company.company_name'))])
        </div>

        <div class="flex justify-end pt-4 border-t border-brand-200">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Save SMTP settings
            </button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.settings.mail.test') }}" class="bg-white rounded-xl border border-brand-200 p-6 space-y-4">
        @csrf
        <h3 class="font-medium text-brand-900">Send test email</h3>
        <p class="text-sm text-brand-500">Uses the saved settings above (save first if you changed them).</p>
        <div class="flex flex-col sm:flex-row gap-3 sm:items-end">
            @include('admin.components.input', ['name' => 'test_email', 'label' => 'Recipient', 'type' => 'email', 'value' => old('test_email', auth()->user()?->email)])
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-sm font-medium rounded-lg transition shrink-0 h-[42px]">
                <i data-lucide="send" class="w-4 h-4"></i> Send test
            </button>
        </div>
    </form>
</div>
@endsection
