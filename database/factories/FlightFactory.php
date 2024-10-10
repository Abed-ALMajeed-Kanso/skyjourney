<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
