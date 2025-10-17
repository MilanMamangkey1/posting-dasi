<?php

namespace Database\Factories;

use App\Models\EducationalContent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\ContentAsset>
 */
class ContentAssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = Arr::random(['video', 'photo', 'document']);

        $storagePath = match ($type) {
            'photo' => 'photos/' . Str::slug($this->faker->unique()->sentence()) . '.jpg',
            'document' => 'documents/' . Str::slug($this->faker->unique()->words(3, true)) . '.pdf',
            default => null,
        };

        return [
            'educational_content_id' => EducationalContent::factory(),
            'type' => $type,
            'storage_path' => $storagePath,
            'external_url' => $type === 'video'
                ? $this->faker->url()
                : null,
            'caption' => $this->faker->optional()->sentence(),
            'ordering' => $this->faker->numberBetween(0, 10),
            'meta' => [
                'duration' => $type === 'video' ? $this->faker->numberBetween(60, 600) : null,
                'dimensions' => $type === 'photo' ? '1280x720' : null,
                'filesize_kb' => $type === 'document' ? $this->faker->numberBetween(80, 512) : null,
            ],
        ];
    }
}
