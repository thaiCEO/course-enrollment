<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'address_line',
        'city',
        'phone',
        'is_main',
    ];


    protected $casts = [
        'is_main' => 'boolean',
    ];

    /**
     * Polymorphic relationship to parent model (Student or Teacher)
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}
