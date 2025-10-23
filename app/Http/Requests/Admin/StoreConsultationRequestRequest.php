<?php

namespace App\Http\Requests\Admin;

use App\Models\ConsultationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConsultationRequestRequest extends FormRequest
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
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'issue_description' => ['required', 'string'],
            'whatsapp_number' => ['required', 'string', 'regex:/^\+?[1-9]\d{7,14}$/'],
            'status' => ['sometimes', 'string', Rule::in(ConsultationRequest::STATUSES)],
            'admin_notes' => ['nullable', 'string'],
            'handled_at' => ['nullable', 'date'],
            'handled_by' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('whatsapp_number')) {
            $this->merge([
                'whatsapp_number' => preg_replace('/\s+/', '', (string) $this->input('whatsapp_number')),
            ]);
        }
    }
}
