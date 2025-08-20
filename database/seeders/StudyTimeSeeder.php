<?php

namespace Database\Seeders;

use App\Models\StudyTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Example: For Course ID = 1
        StudyTime::create([
            'course_id'  => 3,
            'day_type'   => 'weekday',
            'start_time' => '08:00:00',
            'end_time'   => '10:00:00',
        ]);

        StudyTime::create([
            'course_id'  => 3,
            'day_type'   => 'weekend',
            'start_time' => '09:00:00',
            'end_time'   => '11:00:00',
        ]);

        // Example: For Course ID = 2
        StudyTime::create([
            'course_id'  => 4,
            'day_type'   => 'weekday',
            'start_time' => '14:00:00',
            'end_time'   => '16:00:00',
        ]);

        StudyTime::create([
            'course_id'  => 4,
            'day_type'   => 'weekend',
            'start_time' => '13:00:00',
            'end_time'   => '15:00:00',
        ]);
    }
}
