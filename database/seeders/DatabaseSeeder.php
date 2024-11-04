<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger;  
use App\Models\Flight;  
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

      // Flight::factory()->count(50)->create();       
      Flight::factory()->count(10)->create();    

      // Passenger::factory()->count(1000)->create();  
      Passenger::factory()->count(5)->create();

      // large data samples can be seeded but it take time 

      // User Samples for Excel import
      User::factory()->count(10)->create();

      // To test the functionality of the reminder email
      // I changed the deparature time of one of the flights 
      // which have a passenger in exactly 24 hours before, and
      // I changed the email of the passenger to my personel email
      // after I also generated an app password of my personel email
      // and set it in the .env file and I runned: php artisan flights:send-reminders
      
    }
}
