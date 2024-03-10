<?php

namespace App\Enums;

enum CheckStatus: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';

    public static function values(): array
    {
        return array_map(fn ($type) => $type->value, self::cases());
    }
}
