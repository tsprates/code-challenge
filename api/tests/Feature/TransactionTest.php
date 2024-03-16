<?php

namespace Tests\Feature;

use App\Enums\CheckStatus;
use App\Models\Check;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_all_transactions(): void
    {
        User::factory($this->fakeCredentials())
            ->has(Transaction::factory()->count(3))
            ->create();

        $accessToken = $this->login()['access_token'];

        $this
            ->withHeaders(['Authorization' =>  "bearer {$accessToken}"])
            ->get('/api/transactions')
            ->assertSuccessful();
    }

    /** @dataProvider transactionProvider */
    public function test_user_can_list_transactions($url): void
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

    public function test_add_purchase()
    {
        $income = Transaction::factory(['amount' => 999.99])
            ->has(Check::factory()->accepted())
            ->income();

        User::factory($this->fakeCredentials())
            ->has($income)
            ->create();

        $accessToken = $this->login()['access_token'];

        $payload = [
            'amount' => 10.5,
            'description' => 'Test expense',
        ];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/expenses', $payload)
            ->assertCreated();
    }

    public function test_fails_adding_a_purchase_due_to_insufficient_balance()
    {
        User::factory($this->fakeCredentials())->create();

        $accessToken = $this->login()['access_token'];

        $payload = [
            'amount' => 10.5,
            'description' => 'Test expense',
        ];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/expenses', $payload)
            ->assertBadRequest()
            ->assertJsonValidationErrors(['amount']);
    }

    public function test_fails_adding_a_purchase_with_invalid_amount()
    {
        User::factory($this->fakeCredentials())->create();

        $accessToken = $this->login()['access_token'];

        $payload = [
            'amount' => 'invalid',
            'description' => 'Test expense',
        ];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/expenses', $payload)
            ->assertBadRequest()
            ->assertJsonValidationErrors(['amount']);
    }

    public function test_fails_adding_a_purchase_with_missing_description()
    {
        User::factory($this->fakeCredentials())->create();

        $accessToken = $this->login()['access_token'];

        $payload = [
            'amount' => '10.5',
            // no description
        ];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/expenses', $payload)
            ->assertBadRequest()
            ->assertJsonValidationErrors(['description']);
    }

    public function test_deposit_check()
    {
        Storage::fake('public');

        $user = User::factory($this->fakeCredentials())->create();

        $accessToken = $this->login()['access_token'];

        $payload = [
            'amount' => 10.5,
            'description' => 'Test income',
            'picture' => UploadedFile::fake()->image('check.jpg', 640, 380),
        ];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/incomes', $payload)
            ->assertCreated();

        $user->fresh();

        Storage::disk('public')->assertExists(basename($user->picture));
    }

    public function test_fails_deposit_check_with_missing_picture()
    {
        User::factory($this->fakeCredentials())->create();

        $accessToken = $this->login()['access_token'];

        $payload = [
            'amount' => 10.5,
            'description' => 'Test income',
        ];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/incomes', $payload)
            ->assertJsonValidationErrors(['picture']);
    }

    public function test_fails_deposit_check_with_invalid_size_picture()
    {
        User::factory($this->fakeCredentials())->create();

        $accessToken = $this->login()['access_token'];

        $payload = [
            'amount' => 10.5,
            'description' => 'Test income',
            'picture' => UploadedFile::fake()->image('check.jpg', 800, 600), // image size invalid
        ];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/incomes', $payload)
            ->assertJsonValidationErrors(['picture']);
    }

    public function test_fails_when_user_when_tries_to_change_check_status()
    {
        $income = Transaction::factory(['amount' => 999.99])
            ->has(Check::factory()->pending())
            ->income();

        User::factory($this->fakeCredentials())
            ->has($income)
            ->create();

        $accessToken = $this->login()['access_token'];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->patch('/api/checks/1/status', ['status' => CheckStatus::Accepted->value])
            ->assertForbidden();
    }

    public function test_admin_can_change_check_status_to_accepted()
    {
        $income = Transaction::factory(['amount' => 999.99])
            ->has(Check::factory()->pending())
            ->income();

        User::factory($this->fakeCredentials())
            ->admin()
            ->has($income)
            ->create();

        $accessToken = $this->login()['access_token'];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->patch('/api/checks/1/status', ['status' => CheckStatus::Accepted->value])
            ->assertSuccessful();
    }
}
