<?php

use App\Models\Customer;
use App\Models\User;
use function Pest\Laravel\getJson;

test('i can list all customers', function () {
    $user = User::factory()->create();

    Customer::factory()->count(5)->create([
        'user_id' => $user->id,
    ]);

    $this->signIn($user);

    $response = getJson(route('api.v1.customers.index'));
    $response->assertOk();

    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'identification_number',
                'identification_type',
                'created_at',
                'updated_at',
            ],
        ],
    ]);
});
