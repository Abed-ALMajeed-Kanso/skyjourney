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

      // Create 50 flights using the factory
      // Flight::factory()->count(50)->create();       
      // Flight::factory()->count(8)->create();    

      // Create 1000 passengers using the factory
      // Passenger::factory()->count(1000)->create();  
      // Passenger::factory()->count(5)->create();

  
      // large data samples can be seeded but it take time 
      // and errors in relational data occured

      // User Samples for Excel import
      // User::factory()->count(8)->create();


      // To test the functionality of the reminder email
      // I changed the deparature time of one of the flights 
      // which have a passenger in exactly 24 hours before, and
      // I changed the email of the passenger to my personel email
      // after I also generated an app password of my personel email
      // and set it in the .env file and I runned: php artisan flights:send-reminders
      
      // Auditing was applied for Users, Flights, and Passengers Tables.

      // since only API testing was performed not blades, all APIs were
      // listed in the VerifyCsrfToken in the protected array to be avoided.

      // S3 was not used and images were stored locally in the 
      // storage/app/uploads directory (also the excel file is their)
      // only testing the image was with a form.

      // Security headers and Sanitize Input are middlewares added in the kernel.
      
    }
}
