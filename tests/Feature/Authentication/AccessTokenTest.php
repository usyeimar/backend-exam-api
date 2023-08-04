<?php

use App\Models\User;
use Laravel\Passport\ClientRepository;
use function Pest\Laravel\postJson;


beforeEach(function () {
    $client = new ClientRepository();

    $passport = $client->createPersonalAccessClient(
        null,
        'Test Personal Access Client',
        'http://localhost'
    );
    config()->set('passport.personal_access_client.id', $passport->id);
    config()->set('passport.personal_access_client.secret', $passport->secret);
});

test('can login with valid credentials', function () {
    $user = User::factory()->create();
    $response = postJson(
        route('auth.login'),
        [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'test device',
        ]
    );

    $response->assertJsonStructure([
        'access_token',
        'token_type',
        'expires_at',
    ]);
});

function validCredentials(array $overrides = []): array
{
    return array_merge([
        'email' => 'yeimar112003@gmail.com',
        'password' => 'password',
        'device_name' => 'Test Device',
    ], $overrides);
}

test('password must be valid', function () {
    $user = User::factory()->create();
    $response = postJson(
        route('auth.login'),
        validCredentials([
            'email' => $user->email,
            'password' => 'invalid-password',
        ])
    );

    $response->assertJsonFragment([
        'errors' => [
            [
                'title' => 'Oops! Something went wrong.',
                'detail' => 'Invalid Credentials provided, verify your email and password and try again.',
            ],
        ],
    ]);
});

test('email is required', function () {
    $user = User::factory()->create();
    $response = postJson(
        route('auth.login'),
        validCredentials([
            'email' => null,
        ])
    );

    $response->assertJsonStructure([
        'errors' => [
            [
                'title',
                'detail',
                'source' => [
                    'pointer',
                ],
            ],
        ],
    ]);
});
