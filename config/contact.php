<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Contact form rate limits (per IP)
    |--------------------------------------------------------------------------
    */

    'rate_limit' => [
        'per_minute' => (int) env('CONTACT_RATE_LIMIT_PER_MINUTE', 5),
        'per_hour' => (int) env('CONTACT_RATE_LIMIT_PER_HOUR', 15),
        'per_day' => (int) env('CONTACT_RATE_LIMIT_PER_DAY', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Spam protection
    |--------------------------------------------------------------------------
    */

    'spam' => [
        'min_seconds_on_form' => (int) env('CONTACT_MIN_FORM_SECONDS', 3),
        'max_form_age_seconds' => (int) env('CONTACT_MAX_FORM_AGE_SECONDS', 7200),
        'max_urls_in_message' => (int) env('CONTACT_MAX_URLS_IN_MESSAGE', 3),
        'duplicate_window_seconds' => (int) env('CONTACT_DUPLICATE_WINDOW_SECONDS', 600),
    ],

    'honeypot_field' => 'company_website',

];
