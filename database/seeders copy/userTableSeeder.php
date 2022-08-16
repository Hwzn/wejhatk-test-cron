<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use  App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   
    public function run()
    {
        DB::table('users')->delete();
       User::create([
           'name'=>'abdelkawy',
           'phone'=>'012012',
           'password'=>Hash::make('11111111'),
        //    'password'=>'123'
        ]);
       
    }
}
