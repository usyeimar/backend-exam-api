<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can register', function () {
    $response = $this->postJson(
        route('auth.register'),
        $data = validCredentials()
    )->assertJsonStructure([
        'access_token',
        'token_type',
        'expires_at',

    ]);

    $this->assertDatabaseHas('users', [
        'first_name' => $data['first_name'],
    ]);
});

function validCredentials(array $data = []): array
{
    return array_merge([
        'first_name' => 'Weimar',
        'email' => 'yeimar112003@gmail.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
        'device_name' => 'Test Device',
    ], $data);
}

test('authenticated users cannot register again', function () {
    $response = $this->postJson(route('auth.register'));
    $response->assertUnprocessable();
    $response->assertJsonFragment([
        'source' => [
            'pointer' => '/email',
        ],
    ]);
});

test('name is required', function () {
    $response = $this->postJson(
        route('auth.register'),
        validCredentials([
            'first_name' => '',
        ])
    );

    $response->assertUnprocessable();

    $response->assertJsonFragment([
        'source' => [
            'pointer' => '/first_name',
        ],
    ]);
});

test('email is required', function () {
    $response = $this->postJson(
        route('auth.register'),
        validCredentials([
            'email' => '',
        ])
    );

    $response->assertUnprocessable();

    $response->assertJsonFragment([
        'source' => [
            'pointer' => '/email',
        ],
    ]);
});

test('password is required', function () {
    $response = $this->postJson(
        route('auth.register'),
        validCredentials([
            'password' => '',
        ])
    );

    $response->assertUnprocessable();

    $response->assertJsonFragment([
        'source' => [
            'pointer' => '/password',
        ],
    ]);
});

test('password confirmation is required', function () {
    $response = $this->postJson(
        route('auth.register'),
        validCredentials([
            'password_confirmation' => '',
        ])
    );

    $response->assertUnprocessable();

    $response->assertJsonFragment([
        'source' => [
            'pointer' => '/password',
        ],
    ]);
});
