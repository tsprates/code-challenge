<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function fakeCredentials(array $extra = []): array
    {
        return [
            'email' => 'test@example.com',
            'password' => 'secret',
        ] + $extra;
    }

    protected function login(array $extra = []): array
    {
        $response = $this->post('/api/auth/login', $this->fakeCredentials($extra));

        return json_decode($response->getContent(), true);
    }
}
