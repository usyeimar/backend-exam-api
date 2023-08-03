<?php

use App\Models\Customer;
use App\Models\User;

test('i can delete a customer', function () {
    $customer = Customer::factory()->create();
    $user = User::factory()->create();
    $this->signIn($user);
    $response = $this->deleteJson(route('api.v1.customers.destroy', $customer->id));
    $response->assertNoContent();
});
