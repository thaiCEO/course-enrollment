<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Teacher::create([
            'name' => 'Teacher mara',
            'email' => 'mara@school.com',
            'phone' => '098889900',
            'bio' => 'Math expert',
            'specialization' => 'Mathematics',
            'profile_image' => null,
        ]);
    }
}
