<?php

use App\Models\User;
use function Pest\Laravel\deleteJson;

it('i can delete a user', function () {
    $user = User::factory()->create();
    $this->signIn($user);

    $userToDelete = User::factory()->create();

    $response = deleteJson(route('api.v1.users.destroy', $userToDelete->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing(
        'users',
        [
            'id' => $userToDelete->id,
        ]
    );
});
