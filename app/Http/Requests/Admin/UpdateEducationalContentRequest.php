<?php

namespace App\Http\Requests\Admin;

use App\Models\EducationalContent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEducationalContentRequest extends FormRequest
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
        $type = $this->resolveType();

        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', 'string', Rule::in(EducationalContent::TYPES)],
            'summary' => ['sometimes', 'nullable', 'string'],
            'body' => [
                'sometimes',
                Rule::when(
                    fn () => in_array($type, [EducationalContent::TYPE_NARRATIVE, EducationalContent::TYPE_MATERIAL], true),
                    ['required', 'string'],
                    ['nullable', 'string']
                ),
            ],
            'source_url' => [
                'sometimes',
                Rule::when(
                    fn () => $type === EducationalContent::TYPE_VIDEO,
                    ['required', 'string', 'url', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//i'],
                    ['nullable', 'string']
                ),
            ],
            'file' => [
                'sometimes',
                Rule::when(
                    fn () => $type === EducationalContent::TYPE_PHOTO,
                    ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
                    ['prohibited']
                ),
            ],
        ];
    }

    private function resolveType(): ?string
    {
        $routeContent = $this->route('educational_content');

        return $this->input('type', $routeContent?->type);
    }
}
