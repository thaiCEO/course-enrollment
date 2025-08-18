<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'bio',
        'specialization',
        'profile_image',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function enrollments() {
         return $this->hasMany(Enrollment::class); // Correct model name
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
