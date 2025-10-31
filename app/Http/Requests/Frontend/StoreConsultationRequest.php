<?php

namespace App\Http\Requests\Frontend;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $recaptchaKey = config('services.recaptcha.key');
        $recaptchaSecret = config('services.recaptcha.secret');
        $recaptchaEnabled = ! empty($recaptchaKey) && ! empty($recaptchaSecret);

        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'issue_description' => ['required', 'string'],
            'whatsapp_number' => ['required', 'string', 'regex:/^\+?[1-9]\d{7,14}$/'],
        ];

        $rules['g-recaptcha-response'] = $recaptchaEnabled
            ? ['required', 'string', new Recaptcha()]
            : ['nullable', 'string'];

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('whatsapp_number')) {
            $rawNumber = (string) $this->input('whatsapp_number');
            $normalizedNumber = preg_replace('/\D+/', '', $rawNumber) ?? '';

            if ($normalizedNumber !== '') {
                if (str_starts_with($normalizedNumber, '00')) {
                    $normalizedNumber = substr($normalizedNumber, 2);
                } elseif (str_starts_with($normalizedNumber, '0')) {
                    $normalizedNumber = '62' . ltrim($normalizedNumber, '0');
                }

                $normalizedNumber = '+' . ltrim($normalizedNumber, '+');
            }

            $this->merge([
                'whatsapp_number' => $normalizedNumber,
            ]);
        }
    }
}
