<?php

namespace Database\Seeders;

use App\Models\ParkingSpot;
use Illuminate\Database\Seeder;

class ParkingSpotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ParkingSpot::factory(15)->create();
    }
}
