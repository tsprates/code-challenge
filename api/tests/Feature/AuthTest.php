<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_correctly(): void
    {
        User::factory($this->fakeCredentials())
            ->create();

        $this
            ->post('/api/auth/login', $this->fakeCredentials())
            ->assertSuccessful()
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    public function test_admin_can_login_correctly(): void
    {
        User::factory($this->fakeCredentials())
            ->admin()
            ->create();

        $this
            ->post('/api/auth/login', $this->fakeCredentials())
            ->assertSuccessful()
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    public function test_register_a_user(): void
    {
        $data = ['name' => 'Test Name'];

        $this
            ->post('/api/auth/register', $this->fakeCredentials($data))
            ->assertCreated();

        $this->assertDatabaseHas('users', $data);
    }

    public function test_fails_when_registering_a_user_with_missing_name(): void
    {
        $this
            ->post('/api/auth/register', $this->fakeCredentials())
            ->assertBadRequest()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_non_existent_user_cannot_login(): void
    {
        User::factory($this->fakeCredentials())->create();

        $this
            ->post('/api/auth/login', ['email' => 'invalid_user', 'password' => 'invalid_pass'])
            ->assertUnauthorized();
    }

    public function test_logged_user_can_access_me_page(): void
    {
        $user = User::factory($this->fakeCredentials())
            ->create();

        $accessToken = $this->login()['access_token'];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/auth/me')
            ->assertSuccessful()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('id', 1)
                    ->where('name', $user['name'])
                    ->where('email', $user['email'])
                    ->where('is_admin', $user['is_admin'])
                    ->etc()
            );
    }

    public function test_logged_user_can_loggout(): void
    {
        User::factory($this->fakeCredentials())->create();

        $accessToken = $this->login()['access_token'];

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/auth/logout')
            ->assertSuccessful()
            ->assertJson(['message' => 'Successfully logged out']);
    }

    public function test_expired_session_user(): void
    {
        User::factory($this->fakeCredentials())->create();

        $accessToken = $this->login()['access_token'];

        $this->travelTo(now()->addDays(1));

        $this
            ->withHeaders(['Authorization' => "bearer {$accessToken}"])
            ->post('/api/auth/me')
            ->assertRedirect(route('login'));
    }
}
