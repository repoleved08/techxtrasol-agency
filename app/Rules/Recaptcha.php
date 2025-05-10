<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements Rule
{
    public function passes($attribute, $value)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        $response = $response->json();

        if (config('recaptcha.version') === 'v3') {
            return $response['success'] && $response['score'] >= config('recaptcha.score_threshold');
        }

        return $response['success'];
    }

    public function message()
    {
        return 'The reCAPTCHA verification failed. Please try again.';
    }
}
