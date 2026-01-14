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
        Room::insert([
            [
                'name'      => 'Test room 1',
                'capacity'  => 3
            ],
            [
                'name'      => 'Test room 2',
                'capacity'  => 5
            ],
            [
                'name'      => 'Test room 3',
                'capacity'  => 1
            ],
        ]);
    }
}
