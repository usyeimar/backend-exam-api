<?php

use App\Models\User;
use function Pest\Laravel\getJson;

it('i can get all users', function () {
    $user = User::factory()->create();
    $this->signIn($user);

    $response = getJson(route('api.v1.users.index'));

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'users' => [
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links',
            'first_page_url',
            'last_page',
            'from',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ],
    ]);
});
