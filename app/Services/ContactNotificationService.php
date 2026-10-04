<?php

namespace App\Services;

use App\Mail\ContactFormSubmittedNotification;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactNotificationService
{
    public function notifyAdmin(ContactSubmission $submission): void
    {
        $recipients = $this->recipientAddresses();

        if ($recipients === []) {
            Log::warning('Contact form submitted but no notification email is configured.', [
                'submission_id' => $submission->id,
            ]);

            return;
        }

        try {
            Mail::to($recipients)->send(new ContactFormSubmittedNotification($submission));
        } catch (\Throwable $exception) {
            Log::error('Failed to send contact form notification email.', [
                'submission_id' => $submission->id,
                'recipients' => $recipients,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /** @return array<int, string> */
    public function recipientAddresses(): array
    {
        $notificationList = trim((string) (settings('company.contact_notification_email') ?? ''));

        if ($notificationList !== '') {
            return $this->parseEmailList($notificationList);
        }

        $publicContact = trim((string) (settings('company.email') ?? ''));

        if ($publicContact !== '') {
            return $this->parseEmailList($publicContact);
        }

        return [];
    }

    /** @return array<int, string> */
    private function parseEmailList(string $raw): array
    {
        return collect(preg_split('/[\s,;]+/', $raw, -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn (string $email) => trim($email))
            ->filter(fn (string $email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique(fn (string $email) => strtolower($email))
            ->values()
            ->all();
    }
}
