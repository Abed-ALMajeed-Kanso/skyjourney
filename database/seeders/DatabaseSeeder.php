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

      // Note: roles were added to the Databse manually by
      // the following SQL statements:

    


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



  /*INSERT INTO roles (name, guard_name, created_at, updated_at) VALUES 
      ('admin', 'web', NOW(), NOW()),  
      ('viewer', 'web', NOW(), NOW());
      
      Permissions for Users
      INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES 
          ('view-users', 'api', NOW(), NOW()),     -- for viewing users list
          ('view-user', 'api', NOW(), NOW()),      -- for viewing a single user
          ('create-user', 'api', NOW(), NOW()),    -- for creating a new user
          ('update-user', 'api', NOW(), NOW()),    -- for updating an existing user
          ('delete-user', 'api', NOW(), NOW()),    -- for deleting a user
          ('import-users', 'api', NOW(), NOW());   -- for importing users

      Permissions for Passengers
      INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES 
          ('view-passengers', 'api', NOW(), NOW()), -- for viewing passengers list
          ('view-passenger', 'api', NOW(), NOW()),  -- for viewing a single passenger
          ('create-passenger', 'api', NOW(), NOW()), -- for creating a new passenger
          ('update-passenger', 'api', NOW(), NOW()), -- for updating an existing passenger
          ('delete-passenger', 'api', NOW(), NOW()); -- for deleting a passenger

      Permissions for Flights
      INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES 
          ('view-flights', 'api', NOW(), NOW()),    -- for viewing flights list
          ('view-flight', 'api', NOW(), NOW()),     -- for viewing a single flight
          ('create-flight', 'api', NOW(), NOW()),   -- for creating a new flight
          ('update-flight', 'api', NOW(), NOW()),   -- for updating an existing flight
          ('delete-flight', 'api', NOW(), NOW());   -- for deleting a flight

      -- Permissions for Session (Authentication)
      INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES 
          ('login', 'api', NOW(), NOW()),            -- for logging in
          ('logout', 'api', NOW(), NOW());           -- for logging out

      -- Permissions for Admin Role
      INSERT INTO role_has_permissions (role_id, permission_id) VALUES 
          (1, 1),  -- view-users
          (1, 2),  -- view-user
          (1, 3),  -- create-user
          (1, 4),  -- update-user
          (1, 5),  -- delete-user
          (1, 6),  -- import-users
          (1, 7),  -- view-passengers
          (1, 8),  -- view-passenger
          (1, 9),  -- create-passenger
          (1, 10), -- update-passenger
          (1, 11), -- delete-passenger
          (1, 12), -- view-flights
          (1, 13), -- view-flight
          (1, 14), -- create-flight
          (1, 15), -- update-flight
          (1, 16), -- delete-flight
          (1, 17), -- login
          (1, 18); -- logout

      -- Permissions for Viewer Role
      INSERT INTO role_has_permissions (role_id, permission_id) VALUES 
          (3, 1),  -- view-users
          (3, 2),  -- view-user
          (3, 7),  -- view-passengers
          (3, 8),  -- view-passenger
          (3, 12), -- view-flights
          (3, 13); -- view-flight


      */