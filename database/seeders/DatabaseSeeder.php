<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger;  // Import the Passenger model
use App\Models\Flight;  // Import the Passenger model

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * @return void
     */
    public function run(): void
    {

        // Create 50 flights using the factory
      //  Flight::factory()->count(50)->create();       
        Flight::factory()->count(5)->create();    

        // Create 1000 passengers using the factory
      // Passenger::factory()->count(1000)->create();  
        Passenger::factory()->count(2)->create();
    }
}
