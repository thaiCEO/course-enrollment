<?php

namespace Database\Seeders;

use App\Models\course;
use App\Models\enrollments;
use App\Models\student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = student::where('student_number', 'STU001')->first();
        $course = course::where('title', 'Algebra 101')->first();

        enrollments::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'enrolled_date' => now()->toDateString(),
            'payment_status' => 'paid',
            'payment_method' => 'bakong',
        ]);
    }
}
