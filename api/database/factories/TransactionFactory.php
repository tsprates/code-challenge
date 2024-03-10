<?php

namespace Database\Factories;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $transactionTypes = TransactionType::values();

        return [
            'description' => $this->faker->name(),
            'amount' => $this->faker->randomFloat(3, 0, 100),
            'type' => $this->faker->randomElement($transactionTypes),
        ];
    }
}
