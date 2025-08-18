<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\enrollments;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enrollment = enrollments::first(); // ← ✅ This is correct
        $admin = Admin::first();

        if ($enrollment && $admin) {
            Payment::create([
                'enrollment_id' => $enrollment->id,
                'amount' => 50.00,
                'status' => 'success',
                'payment_method' => 'bakong',
                'paid_at' => now(),
                'created_by_admin_id' => $admin->id,
                'updated_by_admin_id' => $admin->id,
            ]);
        }
    }
}
