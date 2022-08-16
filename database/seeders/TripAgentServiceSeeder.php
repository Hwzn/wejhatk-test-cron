<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TripagentsService;
class TripAgentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tripagent_service')->delete();
        for($i=1;$i<=7;$i++)
        {
            DB::table('tripagent_service')->insert([
                'service_id'=>rand(1,7),
                'tripagent_id'=>rand(1,7),
                 'created_at'=>now(),
                 'updated_at'=>now(),
            ]);
        }
    }
}
