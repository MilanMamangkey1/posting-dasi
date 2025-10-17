<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\ConsultationRequest>
 */
class ConsultationRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $submittedAt = $this->faker->dateTimeBetween('-6 weeks', 'now');
        $status = Arr::random(['new', 'in_review', 'scheduled', 'completed', 'rejected']);
        $respondedAt = in_array($status, ['scheduled', 'completed', 'rejected'], true)
            ? $this->faker->dateTimeBetween($submittedAt, 'now')
            : null;
        $assignedTo = in_array($status, ['in_review', 'scheduled', 'completed'], true)
            ? User::factory()
            : null;

        return [
            'uuid' => (string) Str::uuid(),
            'full_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->optional()->safeEmail(),
            'address_line' => $this->faker->optional()->address(),
            'notes_from_public' => $this->faker->optional()->paragraph(),
            'source' => Arr::random(['qr_code', 'direct_link']),
            'status' => $status,
            'assigned_to' => $assignedTo,
            'submitted_at' => $submittedAt,
            'responded_at' => $respondedAt,
        ];
    }

    public function newStatus(): self
    {
        return $this->state(fn () => [
            'status' => 'new',
            'assigned_to' => null,
            'responded_at' => null,
        ]);
    }
}
