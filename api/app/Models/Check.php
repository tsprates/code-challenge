<?php

namespace App\Models;

use App\Enums\CheckStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Check extends Model
{
    use HasFactory;

    protected $hidden = [
        'transaction_id', 'updated_at'
    ];

    protected $fillable = [
        'picture', 'status', 'transaction_id', 'picture'
    ];

    public static function listAllPending(): Collection
    {
        return DB::table('checks')
            ->join('transactions', 'checks.transaction_id', '=', 'transactions.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->where('checks.status', CheckStatus::Pending->value)
            ->select(['checks.id', 'users.name as user', 'checks.created_at', 'transactions.amount'])
            ->get();
    }

    public static function pendingById(int $id): object
    {
        return DB::table('checks')
            ->join('transactions', 'checks.transaction_id', '=', 'transactions.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->where('checks.status', CheckStatus::Pending->value)
            ->where('checks.id', $id)
            ->first(['checks.id', 'users.name as user', 'users.email', 'checks.picture', 'checks.created_at', 'transactions.amount']);
    }
}
