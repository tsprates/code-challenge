<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\CheckStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function incomes()
    {
        return $this
            ->hasMany(Transaction::class)
            ->where('type', TransactionType::Income->value);
    }

    public function expenses()
    {
        return $this
            ->hasMany(Transaction::class)
            ->where('type', TransactionType::Expense->value);
    }

    public function currentBalance()
    {
        return $this->currentAmountIncomes() - $this->currentAmountExpenses();
    }

    public function currentAmountIncomes()
    {
        return $this->incomes()
            ->whereHas('check', fn ($query) => $query->where('status', CheckStatus::Accepted->value))
            ->sum('amount');
    }

    public function currentAmountExpenses()
    {
        return $this->expenses->sum('amount');
    }

    public function validTransactions()
    {
        $acceptedIncomeIds = Transaction::whereHas('check', fn ($query) => $query->where('status', CheckStatus::Accepted->value))
            ->where('type', TransactionType::Income->value)
            ->where('user_id', $this->id)
            ->select('id');

        return Transaction::where('user_id', $this->id)
            ->where(fn ($query) => $query->where('type', TransactionType::Expense->value)
                ->orWhereIn('id', $acceptedIncomeIds))
            ->orderBy('created_at')
            ->get();
    }
}
