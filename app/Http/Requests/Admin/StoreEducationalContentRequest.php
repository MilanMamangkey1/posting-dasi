<?php

namespace App\Http\Requests\Admin;

use App\Models\EducationalContent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEducationalContentRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(EducationalContent::TYPES)],
            'summary' => ['nullable', 'string'],
            'body' => [
                Rule::when(
                    fn () => in_array($this->input('type'), [EducationalContent::TYPE_NARRATIVE, EducationalContent::TYPE_MATERIAL], true),
                    ['required', 'string'],
                    ['nullable', 'string']
                ),
            ],
            'source_url' => [
                Rule::when(
                    fn () => $this->input('type') === EducationalContent::TYPE_VIDEO,
                    ['required', 'string', 'url', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//i'],
                    ['nullable', 'string']
                ),
            ],
            'file' => [
                Rule::when(
                    fn () => $this->input('type') === EducationalContent::TYPE_PHOTO,
                    ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
                    ['prohibited']
                ),
            ],
        ];
    }
}
