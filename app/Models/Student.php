<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
 use HasFactory;

  protected $fillable = [
        'student_number',
        'username',
        'gender',
        'date_of_birth',
        'phone_number',
        'profile_student',  
    ];

        public function enrollments()
        {
            return $this->hasMany(Enrollment::class);
        }


        public function courses()
        {
            return $this->belongsToMany(Course::class, 'enrollments')->withPivot('enrolled_date');
        }



           public function addresses()
            {
                return $this->morphMany(Address::class, 'addressable');
            }

            /**
             * Get the main/default address (if any)
             */
            public function mainAddress()
            {
                return $this->morphOne(Address::class, 'addressable')->where('is_main', true);
            }


}
