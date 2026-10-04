@php
    $companyName = settings('company.company_name') ?? config('app.name');
    $adminUrl = route('admin.contact-submissions.show', $submission);
    $submittedAt = $submission->created_at?->timezone(config('app.timezone'))->format('M j, Y \a\t g:i A') ?? now()->format('M j, Y');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New contact enquiry</title>
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;-webkit-font-smoothing:antialiased;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f1f5f9;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;">
                    <tr>
                        <td style="padding-bottom:20px;text-align:center;">
                            <span style="display:inline-block;font-size:13px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#0d9488;">{{ $companyName }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 4px 24px rgba(15,23,42,0.06);">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#0f172a 0%,#134e4a 100%);padding:28px 32px;">
                                        <p style="margin:0 0 8px;font-size:12px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:#5eead4;">New contact form submission</p>
                                        <h1 style="margin:0;font-size:22px;line-height:1.3;font-weight:700;color:#ffffff;">{{ $submission->name }}</h1>
                                        @if($submission->company)
                                            <p style="margin:8px 0 0;font-size:15px;color:rgba(255,255,255,0.75);">{{ $submission->company }}</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:28px 32px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:24px;">
                                            <tr>
                                                <td style="padding:12px 0;border-bottom:1px solid #f1f5f9;">
                                                    <p style="margin:0 0 4px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:#64748b;">Email</p>
                                                    <a href="mailto:{{ $submission->email }}" style="font-size:15px;color:#0d9488;text-decoration:none;font-weight:500;">{{ $submission->email }}</a>
                                                </td>
                                            </tr>
                                            @if($submission->phone)
                                            <tr>
                                                <td style="padding:12px 0;border-bottom:1px solid #f1f5f9;">
                                                    <p style="margin:0 0 4px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:#64748b;">Phone</p>
                                                    <p style="margin:0;font-size:15px;color:#0f172a;">{{ $submission->phone }}</p>
                                                </td>
                                            </tr>
                                            @endif
                                            @if($submission->project_type)
                                            <tr>
                                                <td style="padding:12px 0;border-bottom:1px solid #f1f5f9;">
                                                    <p style="margin:0 0 4px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:#64748b;">Project type</p>
                                                    <p style="margin:0;font-size:15px;color:#0f172a;">{{ $submission->project_type }}</p>
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="padding:12px 0;">
                                                    <p style="margin:0 0 4px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:#64748b;">Submitted</p>
                                                    <p style="margin:0;font-size:15px;color:#0f172a;">{{ $submittedAt }}</p>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin:0 0 8px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:#64748b;">Message</p>
                                        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px 18px;margin-bottom:28px;">
                                            <p style="margin:0;font-size:15px;line-height:1.65;color:#334155;white-space:pre-wrap;">{{ $submission->message }}</p>
                                        </div>

                                        <table role="presentation" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="border-radius:9999px;background:#14b8a6;">
                                                    <a href="{{ $adminUrl }}" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:600;color:#042f2e;text-decoration:none;">View in admin</a>
                                                </td>
                                                <td style="padding-left:12px;">
                                                    <a href="mailto:{{ $submission->email }}?subject={{ rawurlencode('Re: Your enquiry — '.$companyName) }}" style="display:inline-block;padding:14px 20px;font-size:14px;font-weight:600;color:#0d9488;text-decoration:none;">Reply to sender</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 8px 0;text-align:center;">
                            <p style="margin:0;font-size:12px;line-height:1.5;color:#94a3b8;">
                                This notification was sent because someone submitted the contact form on {{ config('app.url') }}.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
