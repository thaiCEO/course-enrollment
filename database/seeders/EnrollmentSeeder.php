<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Room;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if there is at least one student, course, and room
        $student = Student::first();
        $course = Course::first();
        $room = Room::first();

        if (!$student || !$course || !$room) {
            $this->command->warn('⚠️ Cannot create enrollment. Make sure Student, Course, and Room exist!');
            return;
        }

        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'room_id' => $room->id,
            'enrolled_date' => now(),
        ]);
        

        $this->command->info('✅ Enrollment created successfully!');
    }
}
