<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\EducationalContent>
 */
class EducationalContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(4);
        $status = Arr::random(['draft', 'published', 'archived']);

        return [
            'uuid' => (string) Str::uuid(),
            'created_by' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'summary' => $this->faker->paragraph(),
            'narrative_md' => $this->faker->paragraphs(3, true),
            'material_md' => $this->faker->paragraphs(2, true),
            'video_url' => $this->faker->optional()->url(),
            'hero_image_path' => $this->faker->optional()->imageUrl(1280, 720, 'education'),
            'status' => $status,
            'published_at' => $status === 'published' ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    public function published(): self
    {
        return $this->state(fn () => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
