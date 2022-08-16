<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Services\SMSServices;
use App\Models\User_verfication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class RegisteredUserController extends Controller
{
    
    public $sms_sevices;
    public function __construct(SMSServices $sms_sevices)
    {
        $this->sms_sevices=$sms_sevices;
    }
    public function create()
    {
        return view('auth.register');
    }

   
    public function store(Request $request)
    {
       
       
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
// dd(gettype($data));
     try 
        {
            DB::beginTransaction(); 
            $verfication=[];

            $user=User::create([
                    'name'=>$data['name'],
                    'phone'=>$data['phone'],
                    'password'=>bcrypt($data['password']),
                ]);

                $verfication['user_id']=$user->id;
                $verfication_data=$this->sms_sevices->setVerficationCode($verfication);
            
        //send to user mobile by smsgetway
        // $message= $this->sms_sevices->getSMSVerifyMessageByAppName($verfication_data->code);
        // app(Twilio::class)->sendSms($user->phone,$message);
    
            DB::commit();

            }
            catch(\Exception $ex){
                DB::rollBack();
            }
            return redirect()->route('put_otpcode');

// return $user;
//  return redirect()->route('put_otpcode');

        // Auth::login($user);
        // return redirect()->route('dashboard.user');

    }

    public function verifyuser(Request $request)
    {
       // dd($request);
        $data=$request->validate([
            'otpcode' => 'required',
        ]);
       
        $check=$this->sms_sevices->checkOtpCode($request->otpcode);
        if(!$check)
        {
           // return 'you enter wrong Code';
		   //لا هترجعني علي صفحة ادخل كود التفعيل
		   return redirect()->route('put_otpcode')->withErrors(['otpcode'=>'الكود الذي ادخلته غير صحيح']);
        }
        else{
              //ختروح علي سيرفر الللي انا عملها هعمل جواها داله عشان تشيل كود التفعيل من جدول
			  $this->sms_sevices->removeOtpCode($request->otpcode);
			  return redirect()->route('dashboard.user');
        }

    }
}
