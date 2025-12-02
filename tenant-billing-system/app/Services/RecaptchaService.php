<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RecaptchaService
{
    /**
     * Verify the provided reCAPTCHA token using Google's verification endpoint.
     */
    public function verify(string $token): bool
    {
        $secret = config('services.recaptcha.secret');

        if (blank($secret)) {
            return false;
        }

        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => $secret,
                'response' => $token,
            ]
        );

        if ($response->failed()) {
            return false;
        }

        return (bool) data_get($response->json(), 'success', false);
    }
}
