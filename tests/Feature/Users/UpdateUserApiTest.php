<?php

use App\Models\User;
use function Pest\Laravel\putJson;

it('i can update a user', function () {
    $user = User::factory()->create();
    $this->signIn($user);

    $userToUpdate = User::factory()->create();

    $data = [
        'first_name' => 'Yeimar-test',
        'last_name' => 'Garcia test',
        'email' => 'hotmail@com.co',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ];

    $response = putJson(route('api.v1.users.update', $userToUpdate->id), $data);

    $response->assertStatus(200);

    $this->assertDatabaseHas(
        'users',
        collect($data)->except([
            'password',
            'password_confirmation',
        ])->toArray()
    );

    $this->assertDatabaseMissing(
        'users',
        [
            'id' => $userToUpdate->id,
            'email' => $userToUpdate->email,
        ]
    );
});
