<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PassengerFactory extends Factory
{
    protected $model = Passenger::class;

    public function definition(): array
    {
        return [
            'flight_id' => Flight::factory(), // Create a new flight and use its ID
            'first_name' => $this->faker->firstName,  // Generates random first name
            'last_name' => $this->faker->lastName,    // Generates random last name
            'email' => $this->faker->unique()->safeEmail,  // Generates unique safe email
            'password' => Hash::make('password'),    // Hashes a fake password
            'dob' => $this->faker->date(),           // Random date for DOB
            'passport_expiry_date' => $this->faker->date(),  // Random date for passport expiry
        ];
    }
}
