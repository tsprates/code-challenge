<?php

namespace App\Enums;

enum TransactionType: string
{
    case Income = 'income';
    case Expense = 'expense';

    public static function values(): array
    {
        return array_map(fn ($type) => $type->value, self::cases());
    }
}
