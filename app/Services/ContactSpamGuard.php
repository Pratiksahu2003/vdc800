<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ContactSpamGuard
{
    public function primeSession(Request $request): void
    {
        $request->session()->put('contact_form_token', Str::random(40));
        $request->session()->put('contact_form_started_at', now()->timestamp);
    }

    public function rateLimitExceeded(Request $request): bool
    {
        return RateLimiter::tooManyAttempts($this->ipKey($request), $this->maxAttemptsPerMinute())
            || RateLimiter::tooManyAttempts($this->ipHourKey($request), $this->maxAttemptsPerHour())
            || RateLimiter::tooManyAttempts($this->ipDayKey($request), $this->maxAttemptsPerDay());
    }

    public function secondsUntilAvailable(Request $request): int
    {
        return max(
            RateLimiter::availableIn($this->ipKey($request)),
            RateLimiter::availableIn($this->ipHourKey($request)),
            RateLimiter::availableIn($this->ipDayKey($request)),
        );
    }

    public function recordSuccessfulSubmission(Request $request): void
    {
        RateLimiter::hit($this->ipKey($request), 60);
        RateLimiter::hit($this->ipHourKey($request), 3600);
        RateLimiter::hit($this->ipDayKey($request), 86400);
    }

    /** Silent reject (honeypot, timing, token) — respond like success to bots. */
    public function shouldRejectSilently(Request $request): bool
    {
        if ($this->honeypotFilled($request)) {
            Log::info('Contact form honeypot triggered.', ['ip' => $request->ip()]);

            return true;
        }

        if (! $this->formTokenValid($request)) {
            Log::info('Contact form invalid or missing session token.', ['ip' => $request->ip()]);

            return true;
        }

        if (! $this->formTimingValid($request)) {
            Log::info('Contact form failed timing check.', ['ip' => $request->ip()]);

            return true;
        }

        return false;
    }

    /** @param  array<string, mixed>  $payload */
    public function isDuplicateSubmission(array $payload): bool
    {
        $window = (int) config('contact.spam.duplicate_window_seconds', 600);
        $fingerprint = hash('sha256', strtolower($payload['email'] ?? '').'|'.trim($payload['message'] ?? ''));
        $cacheKey = 'contact:duplicate:'.$fingerprint;

        if (Cache::has($cacheKey)) {
            return true;
        }

        Cache::put($cacheKey, true, $window);

        return false;
    }

    public function messageLooksSpammy(string $message): bool
    {
        $maxUrls = (int) config('contact.spam.max_urls_in_message', 3);
        preg_match_all('/https?:\/\/|www\./i', $message, $matches);

        return count($matches[0] ?? []) > $maxUrls;
    }

    private function honeypotFilled(Request $request): bool
    {
        $field = (string) config('contact.honeypot_field', 'company_website');

        return filled($request->input($field));
    }

    private function formTokenValid(Request $request): bool
    {
        $submitted = $request->input('contact_form_token');
        $expected = $request->session()->get('contact_form_token');

        return filled($submitted) && filled($expected) && hash_equals($expected, $submitted);
    }

    private function formTimingValid(Request $request): bool
    {
        $startedAt = (int) $request->session()->get('contact_form_started_at', 0);
        if ($startedAt <= 0) {
            return false;
        }

        $elapsed = now()->timestamp - $startedAt;
        $min = (int) config('contact.spam.min_seconds_on_form', 3);
        $max = (int) config('contact.spam.max_form_age_seconds', 7200);

        return $elapsed >= $min && $elapsed <= $max;
    }

    private function ipKey(Request $request): string
    {
        return 'contact:ip:minute:'.$request->ip();
    }

    private function ipHourKey(Request $request): string
    {
        return 'contact:ip:hour:'.$request->ip();
    }

    private function ipDayKey(Request $request): string
    {
        return 'contact:ip:day:'.$request->ip();
    }

    private function maxAttemptsPerMinute(): int
    {
        return max(1, (int) config('contact.rate_limit.per_minute', 5));
    }

    private function maxAttemptsPerHour(): int
    {
        return max(1, (int) config('contact.rate_limit.per_hour', 15));
    }

    private function maxAttemptsPerDay(): int
    {
        return max(1, (int) config('contact.rate_limit.per_day', 30));
    }
}
