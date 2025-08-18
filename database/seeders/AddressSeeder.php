<?php

namespace Database\Seeders;

use App\Models\student;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed addresses for first 3 teachers
        Teacher::take(3)->each(function ($teacher, $i) {
            $teacher->addresses()->createMany([
                [
                    'address_line' => 'Teacher Address ' . ($i + 1),
                    'city' => 'Phnom Penh',
                    'phone' => '01100000' . ($i + 1),
                    'is_main' => true,
                ],
                [
                    'address_line' => 'Backup Address ' . ($i + 1),
                    'city' => 'Siem Reap',
                    'phone' => '01199999' . ($i + 1),
                    'is_main' => false,
                ],
            ]);
        });

        // Seed addresses for first 3 students
        student::take(3)->each(function ($student, $i) {
            $student->addresses()->create([
                'address_line' => 'Student Address ' . ($i + 1),
                'city' => 'Battambang',
                'phone' => '01211111' . ($i + 1),
                'is_main' => true,
            ]);
        });
    }
}
