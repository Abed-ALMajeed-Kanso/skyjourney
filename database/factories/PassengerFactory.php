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
            'flight_id' => Flight::inRandomOrder()->first()->id ?? Flight::factory(), 
            'first_name' => $this->faker->firstName, 
            'last_name' => $this->faker->lastName,    
            'email' => $this->faker->unique()->safeEmail,  
            'password' => Hash::make('password'),    
            'dob' => $this->faker->date(),          
            'passport_expiry_date' => $this->faker->date(),  
            'image' => 'https://skyjourney-images.s3.eu-north-1.amazonaws.com/images/thumbnails/Standard.jpg', 
        ];
    }
}
