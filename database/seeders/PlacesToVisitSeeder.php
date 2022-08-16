<?php

namespace Database\Seeders;

use App\Models\PlacesToVisit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PlacesToVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('places_tovisits')->delete();
        $data=array(
         ['en'=>'Pyramids','ar'=>'الاهرامات'],
         ['en'=>'Porsaid','ar'=>'بورسعيد'],
         ['en'=>'Cairo Tower','ar'=>'برج القاهرة'],
         ['en'=>'El-Alamenin','ar'=>'العلمين'],
         ['en'=>'Citadel of Qatibay','ar'=>'قلعة قايتباي'],

        );

       foreach($data as $data1)
       {
         PlacesToVisit::create([
             'name'=>$data1,
             'photo'=>mt_rand(10000,99999).'.'.'jpg',
             'desc'=>'Places To visit Desc',
         ]);
       }
    }
}
