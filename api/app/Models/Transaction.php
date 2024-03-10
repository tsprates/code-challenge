<?php

namespace App\Models;

use App\Enums\CheckStatus;
use App\Enums\TransactionType;
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

    protected $fillable = [
        'amount', 'description', 'type', 'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y, h:i A',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function check(): HasOne
    {
        return $this->hasOne(Check::class);
    }
    
    public function acceptedCheck(): HasOne
    {
        return $this->hasOne(Check::class)
            ->where('type', CheckStatus::Accepted->value);
    }
}
