<?php

namespace Database\Seeders;

use App\Models\student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        student::create([
            'student_number' => 'STU001',
            'username' => 'sokha',
            'gender' => 'male',
            'date_of_birth' => '2003-05-10',
            'profile_student' => null,
        ]);

        student::create([
            'student_number' => 'STU002',
            'username' => 'srey',
            'gender' => 'female',
            'date_of_birth' => '2004-08-15',
            'profile_student' => null,
        ]);
    }
}
