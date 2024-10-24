<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    public function definition()
    {
        return [
            'number' => $this->faker->bothify('??###'),
            'departure_city' => $this->faker->city,
            'arrival_city' => $this->faker->city,
            'departure_time' => $this->faker->dateTime,
            'arrival_time' => $this->faker->dateTime,
        ];
    }
}
