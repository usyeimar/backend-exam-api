<?php

namespace App\Services\Customers;

use App\Models\Customer;

class CreateCustomers
{
    public function __invoke(
        array $data,
    ) {
        return Customer::query()
            ->create(
                array_filter([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'identification_number' => $data['identification_number'],
                    'identification_type' => $data['identification_type'],
                    'phone_number' => $data['phone_number'],
                    'description' => $data['description'] ?? null,
                    'user_id' => auth()->user()->id,
                    'email' => $data['email'] ?? null,
                    'birthdate' => $data['birthdate'] ?? null,
                    'photo' => $data['photo'] ?? null,
                    'source' => $data['source'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'city' => $data['city'] ?? null,
                    'country' => $data['country'] ?? null,
                    'last_talked_to' => $data['last_talked_to'] ?? null,
                ])
            );
    }
}
