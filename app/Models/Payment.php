<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'enrollment_id',
        'amount',
        'status',
        'payment_method_id',
        'paid_at',
        'created_by_admin_id',
        'updated_by_admin_id',
    ];

    protected $dates = ['paid_at'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }


    public function createdByAdmin()
    {
        return $this->belongsTo(Admin::class, 'created_by_admin_id');
    }


    public function updatedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'updated_by_admin_id');
    }

        // ✅ ADD THIS: Define the relationship to payment method
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
