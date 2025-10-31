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
        $type = $this->input('type');

        return [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(EducationalContent::TYPES)],
            'summary' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'],
            'body' => [
                Rule::when(
                    fn () => $type === EducationalContent::TYPE_NARRATIVE,
                    ['required', 'string'],
                    ['nullable', 'string']
                ),
            ],
            'source_url' => [
                Rule::when(
                    fn () => $type === EducationalContent::TYPE_VIDEO,
                    ['required', 'string', 'url', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//i'],
                    ['nullable', 'string']
                ),
            ],
            'file' => [
                Rule::when(
                    fn () => $type === EducationalContent::TYPE_PHOTO,
                    ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:3072']
                ),
                Rule::when(
                    fn () => $type === EducationalContent::TYPE_MATERIAL,
                    ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx', 'max:3072']
                ),
                Rule::when(
                    fn () => ! in_array($type, [EducationalContent::TYPE_PHOTO, EducationalContent::TYPE_MATERIAL], true),
                    ['prohibited']
                )
            ],
        ];
    }
}
