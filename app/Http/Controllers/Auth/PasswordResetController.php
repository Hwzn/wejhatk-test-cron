<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Services\SMSServices;
use App\Models\User_verfication;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
   
    public $sms_sevices;
    public function __construct(SMSServices $sms_sevices)
    {
        $this->sms_sevices=$sms_sevices;
    } 
    public function index()
    {
        return view('auth.forgot-password');
    }

   
    public function resetpass(Request $request)
    {
        $data = Validator::make($request->all(), [
            'phone'=>'required|min:5|max:15|exists:users,phone',
           ]);
                if($data->fails())
                {
                    return redirect()->route('resetpassword')->withErrors($data->errors());
        
                }
         //1-get user data depend on phone
            $verfication=[];
            $user=User::where('phone',$request->phone)->first();

            //update in user delete vefied and password
            User::findorfail($user->id)->update([
              'verified_at'=>null,
              'password'=>'',
            ]);
            $verfication['user_id']=$user->id;
            $verfication_data=$this->sms_sevices->setVerficationCode($verfication);
            
            return redirect()->route('put_otpcode');
        //send to user mobile by smsgetway

             
    }

    public function changepassword(Request $request)
    {
        $otp_code=$request->otpcode;
        $verificationdata=User_verfication::where('otpcode',$otp_code)->first();
        if($verificationdata)
        {
            return view('auth.changepassword',compact('verificationdata'));
        }
        return redirect()->route('put_otpcode');
    //send to user mobile by smsgetway

    }

    public function updatepassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'otpcode'=>'required|min:5|max:15|exists:users_verficationcode,otpcode',
             'password'=>'required'  
        ]);
                if($data->fails())
                {
                    return redirect()->route('changepassword')->withErrors($data->errors());
        
                }
         $user=User::findorfail($request->user_id);
         $user->update([
            
                'verified_at'=>now(),
                'password'=>bcrypt($request->password),
            
         ]);
        User_verfication::where('user_id',$request->user_id)->delete();
       
        Auth::login($user);
        return redirect()->route('dashboard.user');
    }
}
