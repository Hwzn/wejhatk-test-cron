<?php

namespace Database\Seeders;

use App\Models\Tourguide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TourguideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tour_guides')->delete();
        Tourguide::factory()->count(15)->create();

    }
}
