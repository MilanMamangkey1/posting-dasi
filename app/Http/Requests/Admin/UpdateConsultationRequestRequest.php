<?php

namespace App\Http\Requests\Admin;

use App\Models\ConsultationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateConsultationRequestRequest extends FormRequest
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
            'full_name' => ['sometimes', 'string', 'max:255'],
            'address' => ['sometimes', 'string', 'max:500'],
            'issue_description' => ['sometimes', 'string'],
            'whatsapp_number' => ['sometimes', 'string', 'regex:/^\+?[1-9]\d{7,14}$/'],
            'status' => ['sometimes', 'string', Rule::in(ConsultationRequest::STATUSES)],
            'admin_notes' => ['sometimes', 'nullable', 'string'],
            'handled_at' => ['sometimes', 'nullable', 'date'],
            'handled_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
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
