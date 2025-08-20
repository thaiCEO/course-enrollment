<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

     // Calculate remaining capacity
    public function remainingCapacity()
    {
        return $this->capacity - $this->enrollments()->count();
    }
    // Room.php
    public function studyTimes()
    {
        return $this->hasMany(StudyTime::class);
    }

}
