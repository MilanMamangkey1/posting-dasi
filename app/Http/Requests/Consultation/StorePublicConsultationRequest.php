<?php

namespace App\Http\Requests\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'address_line' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:8', 'max:25'],
            'notes' => ['nullable', 'string', 'max:500'],
            'source' => ['nullable', 'string', 'max:50'],
            'redirect_url' => ['nullable', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => __('Nama lengkap wajib diisi.'),
            'address_line.required' => __('Alamat rumah wajib diisi.'),
            'phone.required' => __('Nomor WhatsApp wajib diisi.'),
        ];
    }
}
