<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'course_id',
        'enrolled_date',
        'payment_status',
        'payment_method',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

   public function teacher() {
    return $this->belongsTo(Teacher::class, 'teacher_id', 'id'); // specify FK & PK explicitly
}


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'enrollment_id');
    }

}
