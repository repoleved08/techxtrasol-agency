<?php

return [
    'enabled' => env('RECAPTCHA_ENABLED', true),
    'site_key' => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    'version' => env('RECAPTCHA_VERSION', 'v2'), // 'v2' or 'v3'
    'skip_ip' => [], // IP addresses to skip validation
    'score_threshold' => 0.5, // Only for v3 - minimum score to pass
];
