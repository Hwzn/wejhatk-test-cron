<?php
namespace App\Http\Triats;
use App\Providers\RouteServiceProvider;
trait AuthTriat
{
   
    public function chekGuard($request)
    {
        if($request->type=='user')
        {
            $guardName='web';
        }
        elseif($request->type=='admin')
        {
            $guardName='admin';
        }
       
        return $guardName;
    }

    public function redirect($request){

        if($request->type == 'user'){
            return redirect()->intended(RouteServiceProvider::USER);
        }
       
        elseif ($request->type == 'admin'){
           // print_r('ddddd');die;
            return redirect()->intended(RouteServiceProvider::ADMIN);
        }
        else{
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

}