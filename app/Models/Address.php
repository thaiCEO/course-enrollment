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


   // Search + filter scope
public function scopeFilter($query, array $filters)
{
    if (!empty($filters['search'])) {
        $s = $filters['search'];

        $query->where(function ($q) use ($s) {
            $q->whereRaw("address_line COLLATE Khmer_100_CI_AI_KS_WS LIKE N'%' + ? + '%'", [$s])
              ->orWhereRaw("city COLLATE Khmer_100_CI_AI_KS_WS LIKE N'%' + ? + '%'", [$s])
              ->orWhereRaw("phone COLLATE Khmer_100_CI_AI_KS_WS LIKE N'%' + ? + '%'", [$s]);
        });
    }

    if (!empty($filters['filter'])) {
        if ($filters['filter'] === 'student') {
            $query->whereHasMorph('addressable', [\App\Models\Student::class]);
        } elseif ($filters['filter'] === 'teacher') {
            $query->whereHasMorph('addressable', [\App\Models\Teacher::class]);
        }
    }

    return $query;
}



}
