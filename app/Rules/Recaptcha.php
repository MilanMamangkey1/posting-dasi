<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class Recaptcha implements ValidationRule
{
    /**
     * Validate the Google reCAPTCHA token (v2 checkbox).
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.recaptcha.secret');

        if (empty($secret)) {
            return;
        }

        if (! is_string($value) || Str::of($value)->trim()->isEmpty()) {
            $fail(__('Validasi reCAPTCHA tidak valid. Silakan coba lagi.'));

            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            $fail(__('Validasi reCAPTCHA gagal diproses. Silakan coba lagi.'));

            return;
        }

        if (! $response->successful()) {
            $fail(__('Validasi reCAPTCHA gagal diproses. Silakan coba lagi.'));

            return;
        }

        $payload = $response->json();

        if (($payload['success'] ?? false) !== true) {
            $fail(__('Validasi reCAPTCHA gagal. Silakan coba lagi.'));
        }
    }
}
