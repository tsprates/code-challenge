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
        return [
            'description' => fake()->word(2),
            'amount' => fake()->randomFloat(3, 0, 100),
            'type' => TransactionType::Expense->value,
        ];
    }

    public function income()
    {
        return $this->state(fn () => ['type' => TransactionType::Income->value]);
    }
}
