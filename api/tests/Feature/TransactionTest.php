<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_transactions(): void
    {
        User::factory($this->fakeCredentials())
            ->has(Transaction::factory()->count(3))
            ->create();

        $accessToken = $this->login()['access_token'];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->get('/api/transactions')
            ->assertSuccessful();
    }
    
    /** @dataProvider transactionProvider */
    public function test_transactions($url): void
    {
        User::factory($this->fakeCredentials())
            ->has(Transaction::factory()->count(3))
            ->create();

        $accessToken = $this->login()['access_token'];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->get($url)
            ->assertSuccessful();
    }

    public static function transactionProvider()
    {
        yield 'list all incomes' => ['/api/incomes'];
        yield 'list all expenses' => ['/api/expenses'];
    }
}
