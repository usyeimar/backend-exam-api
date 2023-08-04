<?php

use App\Models\Customer;
use App\Models\User;
use function Pest\Laravel\putJson;

test('i can update a customer', function () {
    $user = User::factory()->create();
    $this->signIn($user);
    $customer = Customer::factory()->create([
        'first_name' => 'John',
    ]);

    $data = [
        'first_name' => 'Jane Updated',
        'last_name' => 'Doe Updated',
        'email' => 'jane@mail.com',
        'phone_number' => '5678383893',
    ];

    $response = putJson(route('api.v1.customers.update', $customer->id), $data);

    $response->assertOk();

    $this->assertDatabaseHas(table: 'customers', data: [
        'id' => $customer->id,
        'first_name' => 'Jane Updated',
        'last_name' => 'Doe Updated',
        'email' => 'jane@mail.com',
        'phone_number' => '5678383893',
    ]);
});
