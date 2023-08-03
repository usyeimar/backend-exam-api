<?php

use App\Models\User;

test('i can create a customer', function () {
    $user = User::factory()->create();
    $this->signIn($user);

    $data = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'juan@gmail.com',
        'phone_number' => '573217290035',
        'identification_number' => '123456789',
        'identification_type' => 'cc',
    ];

    $response = $this->postJson(route('api.v1.customers.store'), $data);

    $response->assertCreated();

    $response->assertJsonStructure(
        collect($data)->keys()->all()
    );
});
