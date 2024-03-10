<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden = [
        'user_id', 'deleted_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y, h:i A',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
