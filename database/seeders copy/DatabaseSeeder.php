<?php
namespace Database\Seeders;

use App\Models\Tripagent;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        $this->call(userTableSeeder::class);
         $this->call(ServiceTableSeeder::class);
         $this->call(TripagentSeeder::class);
         $this->call(TripAgentServiceSeeder::class);
         $this->call(TourguideSeeder::class);
         
        
    }

    
}
