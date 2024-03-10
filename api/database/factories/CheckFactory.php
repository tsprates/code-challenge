<?php

namespace Database\Factories;

use App\Enums\CheckStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Check>
 */
class CheckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkStatuses = CheckStatus::values();

        return [
            'status' => fake()->randomElement($checkStatuses),
            'picture' => fake()->imageUrl(640, 380, 'check', true),
        ];
    }

    public function accepted()
    {
        return $this->state(fn () => ['status' => CheckStatus::Accepted->value]);
    }

    public function pending()
    {
        return $this->state(fn () => ['status' => CheckStatus::Pending->value]);
    }

    public function rejected()
    {
        return $this->state(fn () => ['status' => CheckStatus::Rejected->value]);
    }
}
