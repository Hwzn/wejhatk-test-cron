<?php

namespace Database\Seeders;

use App\Models\TourGuide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TourGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tour_guides')->delete();
        $data=[
            ['en'=>'ahmed ali','ar'=>'احمد علي'],
            ['en'=>'mouatfa mohamed','ar'=>'مصطفي محمد'],
            ['en'=>'Ayman ali','ar'=>'ايمن علي'],
            ['en'=>'Yaser ahmed','ar'=>'ياسر احمد'],
            ['en'=>'Mostafa khaled','ar'=>'مصطفي خالد'],
            ['en'=>'Waleed Fathy','ar'=>'وليد فتحي'],

        ];

  foreach($data as $data)
  {

    TourGuide::create([
        'name'=>$data,
        'phone'=>mt_rand(10000000,99999999),
        'password'=>bcrypt('11111111'),
        'verified_at'=>now(),

    ]);
   }
    }
}
