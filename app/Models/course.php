<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    use HasFactory;

   protected $fillable = [
        'teacher_id',
        'title',
        'description',
        'course_image',
        'price',
        'is_active',
    ];
    protected $appends = ['course_image_url'];

    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')->withPivot('enrolled_date');
    }


   public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


     public function studyTimes()
    {
        return $this->hasMany(StudyTime::class);
    }


    public function getCourseImageUrlAttribute()
    {
        return $this->course_image
            ? asset('courses/' . $this->course_image)
            : null;
    }


}
