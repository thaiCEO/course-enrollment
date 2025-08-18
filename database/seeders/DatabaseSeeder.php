<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory()->create([
        //     'name' => 'adminthai',
        //     'email' => 'adminthai@gmail.com',
        // ]);

        //  $this->call([
        //     AdminSeeder::class,
        //     StudentSeeder::class,
           
        //     CourseSeeder::class,
        //     EnrollmentSeeder::class,
        //     PaymentSeeder::class,
          
        // ]);
       

      
        $this->call([
              TeacherSeeder::class,
         ]);


        //  $this->call(PaymentMethodSeeder::class);

    }
}
