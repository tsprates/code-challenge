<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidAmount implements ValidationRule
{
    public function __construct(private int|float $currentBalance)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value >= $this->currentBalance) {
            $fail('The current balance is insufficient.');
        }
    }
}
