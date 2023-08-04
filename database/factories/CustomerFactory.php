<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'identification_number' => $this->faker->randomNumber(9),
            'last_talked_to' => $this->faker->dateTime,
            'identification_type' => $this->faker->randomElement(['cc', 'ce', 'ti', 'ppn', 'nit']),
            'country' => $this->faker->country,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'city' => $this->faker->city,
            'source' => $this->faker->randomElement(['facebook', 'instagram', 'google', 'twitter']),
            'photo' => $this->faker->imageUrl(),
            'description' => $this->faker->text,
            'birthdate' => $this->faker->dateTime,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
