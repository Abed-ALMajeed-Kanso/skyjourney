<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger;  
use App\Models\Flight;  
use App\Models\User;

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
      // Flight::factory()->count(50)->create();       
      // Flight::factory()->count(10)->create();    

      // Create 1000 passengers using the factory
      // Passenger::factory()->count(1000)->create();  
      // Passenger::factory()->count(5)->create();

  
      // large data samples can be seeded but it take time 
      // and errors in relational data occured

      // User Samples for Excel import
      // User::factory()->count(10)->create();

      // Note: An Admin role was added in the MySQL Databse
      // for API testing for roles using the following SQL statements:

      // INSERT INTO roles (name, created_at, updated_at) VALUES 
      // ('admin', NOW(), NOW());  

      // INSERT INTO role_user (user_id, role_id, created_at, updated_at) 
      // VALUES (1, 1, NOW(), NOW());

      // To test the functionality of the reminder email
      // I changed the deparature time of one of the flights 
      // which have a passenger in exactly 24 hours before, and
      // I changed the email of the passenger to my personel email
      // after I also generated an app password of my personel email
      // and set it in the .env file and I runned: php artisan flights:send-reminders
      
      // Auditing was applied for Users, Flights, and Passengers Tables.

      
    }
}
