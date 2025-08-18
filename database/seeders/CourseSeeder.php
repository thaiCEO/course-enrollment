<?php

namespace Database\Seeders;

use App\Models\course;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $teacher = Teacher::first();

        course::create([
            'title' => 'Algebra 101',
            'description' => 'Basic Algebra course for beginners',
            'price' => 50.00,
            'is_active' => true,
            'course_image' => null,
        ]);

        Course::create([
            'title' => 'Physics Basics',
            'description' => 'Introduction to fundamental physics',
            'price' => 75.00,
            'is_active' => true,
            'course_image' => null,
        ]);
        
    }
}
