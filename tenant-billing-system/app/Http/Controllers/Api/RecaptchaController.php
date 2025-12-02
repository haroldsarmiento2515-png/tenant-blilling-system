<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;

class RecaptchaController extends Controller
{
    public function verify(Request $request, RecaptchaService $recaptchaService)
    {
        $validated = $request->validate([
            'g-recaptcha-response' => 'required|string',
        ]);

        $isValid = $recaptchaService->verify($validated['g-recaptcha-response']);

        return response()->json([
            'success' => $isValid,
            'message' => $isValid
                ? 'reCAPTCHA validation passed.'
                : 'reCAPTCHA validation failed.',
        ], $isValid ? 200 : 422);
    }
}
