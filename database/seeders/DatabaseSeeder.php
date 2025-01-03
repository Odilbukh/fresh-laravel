<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Hotel;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         $this->call(RandomHotelSeeder::class);
         $this->call(RandomRoomSeeder::class);
         $this->call(UserSeeder::class);
    }
}
