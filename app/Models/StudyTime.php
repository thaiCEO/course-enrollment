<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyTime extends Model
{
     protected $fillable = ['course_id', 'room_id', 'day_type', 'start_time', 'end_time'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
