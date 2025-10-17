<?php

namespace Database\Factories;

use App\Models\ConsultationRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\ConsultationUpdate>
 */
class ConsultationUpdateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = Arr::random(['in_review', 'scheduled', 'completed', 'rejected']);

        return [
            'consultation_request_id' => ConsultationRequest::factory(),
            'recorded_by' => User::factory(),
            'status_after_update' => $status,
            'message' => $this->faker->optional()->paragraph(),
            'follow_up_at' => $status === 'in_review'
                ? $this->faker->dateTimeBetween('now', '+2 weeks')
                : null,
        ];
    }
}
