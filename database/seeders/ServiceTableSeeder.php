<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Serivce;
class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('serivces')->delete();
       
        $data=array(
            ['en'=> 'Packages', 'ar'=> 'الباقات'],
            ['en'=> 'Booking a car"', 'ar'=> 'حجز سيارة'],
            ['en'=> 'Book a hotel', 'ar'=> 'حجز فندق'],
            ['en'=>'Book travel plan','ar'=>'حجز رحله'],
            ['en'=>'Book a license','ar'=>'حجز رخصه قيادة'],
            ['en'=>'Consultation','ar'=>'طلب استشارة'],
            ['en'=>'Other services','ar'=>'خدمات أخري'],
        );
        
       
        foreach($data as $data1)
        {
            Serivce::create([
                'name'=>$data1,
            ]);
        }
    }
}
