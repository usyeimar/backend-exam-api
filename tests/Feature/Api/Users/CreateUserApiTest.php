<?php

use App\Models\User;
use function Pest\Laravel\postJson;

it('can create a user', function () {
    $user = User::factory()->create();
    $this->signIn($user);

    $data = [
        'first_name' => 'Yeimar-test',
        'last_name' => 'Garcia test',
        'email' => 'yeimar@hmaol.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ];

    $response = postJson(route('api.v1.users.store'), $data);

    $response->assertStatus(200);

    $this->assertDatabaseHas(
        'users',
        collect($data)->except([
            'password',
            'password_confirmation',
        ])->toArray()
    );
});

it('first_name is required', function () {
    $user = User::factory()->create();
    $this->signIn($user);

    $data = [
        'last_name' => 'Garcia test',
        'email' => 'do@mail.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ];

    $response = postJson(route('api.v1.users.store'), $data);

    $response->assertStatus(422);

    $response->assertJson([
        'errors' => [
            [
                'title' => 'The given data was invalid.',
                'detail' => 'The first_name field is required.',
                'source' => [
                    'pointer' => '/first_name',
                ],
            ],
        ],
    ]);
});
