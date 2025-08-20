<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => 'A101',
            'capacity' => 30,
        ]);

        Room::create([
            'name' => 'B202',
            'capacity' => 25,
        ]);
    }
}
