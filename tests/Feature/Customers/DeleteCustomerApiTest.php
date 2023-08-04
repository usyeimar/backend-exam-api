<?php

use App\Models\Customer;
use App\Models\User;
use function Pest\Laravel\deleteJson;

test('i can delete a customer', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $this->signIn($user);
    $response = deleteJson(route('api.v1.customers.destroy', $customer->id));
    $response->assertNoContent();
});
