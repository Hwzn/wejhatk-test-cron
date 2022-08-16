<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $data=array('Package','Booking_car','Booking_service','BookingInternational_drivinglicenses',
                'Booking_trip','Booking_consultation','Booking_hotel','Booking_flight'
                 ,'Booking_quickservice','Booking_consultation');
        foreach($data as $data1)
        {
            Serivce::create([
                'name'=>$data1,
            ]);
        }
    }
}
