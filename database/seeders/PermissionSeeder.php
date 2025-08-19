<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'address',
            'admin',
            'course',
            'enrollment',
            'payment',
            'paymentmethod',
            'student',
            'teacher',
        ];

        $crud = ['create', 'read', 'update', 'delete'];

        foreach ($models as $model) {
            foreach ($crud as $action) {
                Permission::firstOrCreate(['name' => $action . ' ' . $model]);
            }
        }
    
    }
}
