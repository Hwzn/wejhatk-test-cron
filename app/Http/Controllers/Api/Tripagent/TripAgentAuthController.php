<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Tripagent;
use App\Models\Tripagent_verfication;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
use App\Http\Services\SMSServices;
use App\Models\AgencyType;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;

class TripAgentAuthController extends Controller
{
    use ApiResponseTrait;
    public $sms_sevices;
    public function __construct(SMSServices $sms_sevices) {
        $this->sms_sevices=$sms_sevices;

    }
    public function login(Request $request)
    {
     
        try{
           //valdtion
            $rules=[
                "phone"=>'required|exists:trip_agents,phone',
                'password'=>'required',
                'device_token'=>'required',
            ];
              $validator=Validator::make($request->all(),$rules);
              if($validator->fails())
              {
                  return response()->json($validator->errors(), 422);
              }

            //login
            $credantionals=$request->only(['phone','password']);
            $token=Auth::guard('tripagent-api')->attempt($credantionals);

            if(!$token)
                return response()->json(['error' => 'invalid username or password'], 401);

            $tripagent=Auth::guard('tripagent-api')->user();

          if($tripagent->verified_at==Null)
           {
            return response()->json(['error' => 'User Not Activated'], 401);
           }
            $tripagent->api_token=$token;
            $tripagent->expires_in= auth()->factory()->getTTL() * 60;

        //send device token
            $exists=$tripagent->DeviceTokens()
            ->where('token','=',$request->device_token)->exists();
            if(!$exists)
            {
                $tripagent->DeviceTokens()->create([
                    'token'=>$request->device_token,
                ]);
            } 
         //send device token
      //   return response()->json('fff');

            return response()->json(['User_data' => $tripagent], 200);

        }
        catch(\Exception $ex)
        {
            return response()->json([
                'message' => $ex,
                'user' => 'd'
            ], 404);
        }
       
    }

    public function logout(Request $request)
    {
       
        $token=$request->header('auth-token');
        if($token)
        {
           try{
            JWTAuth::setToken($token)->invalidate();
            return response()->json(['msg'=>'logout  successful'], 200);
           }
           catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
           {
            return response()->json(['error'=> 'some thing wrong'], 405);

           }
          
 
        }
        else
        {
            return response()->json(['msg'=> 'some thing wrong'], 405);
        }
    }

   

    public function register(Request $request)
    {
    //   $aaa=['a'=>1,'b'=>2];
        $rules=[
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'address' => 'required|string|max:255',
            'agency_id' => 'required|exists:agency_types,id',
            // 'phone' => 'required|string|unique:users',
            'password' => ['required','min:8','confirmed', Rules\Password::defaults()],
            // 'countries' => 'required|exists:countries,id',
            'photo'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
            'commercial_registrationNo'=> 'numeric|digits:10|unique:trip_agents,Commercial_RegistrationNo',
            'commercial_registrationexpirdate'=>'date',
            'license_number'=>'unique:trip_agents,license_number',
            'license_expiry_date'=>'date',
        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }
       //for if user not write otp for any reson and want to repeat register and still not active on sytem
    $image=''; 
       if(Tripagent::where('phone',$request->phone)->exists())
          {
            $user=Tripagent::where('phone',$request->phone)->first();
             if($user->verified_at==null)
             {
                //delete old image if found
                $image=$user->profile_photo;
                $path="public/assets/uploads/Profile/TripAgent/profile/".$image;

                if(File::exists($path))
                {
                    File::delete($path);
                }  
                Tripagent_verfication::where('user_id',$user->id)->delete();
                Tripagent::where('id',$user->id)->delete();
               
             }
             else
             {
                return response()->json(['Error'=>'User Alerady Confirmed in System']);
             }
            
          }

          try 
          {
              DB::beginTransaction(); 
              $verfication=[];
                if(isset($request->commercial_registrationNo) && $request->commercial_registrationNo !==Null) $Commercial_Regist=$request->commercial_registrationNo; else $Commercial_Regist=null;
                if(isset($request->commercial_registrationexpirdate) && $request->commercial_registrationexpirdate !==Null) $CommRegist_ExpiryDate=$request->commercial_registrationexpirdate; else $CommRegist_ExpiryDate=null;
                if(isset($request->license_number) && $request->license_number !==Null) $license_number=$request->license_number; else $license_number=null;
                if(isset($request->license_expiry_date) && $request->license_expiry_date !==Null) $license_expirydate=$request->license_expiry_date; else $license_expirydate=null;
          
                if($request->hasfile('photo')) 
                {
                    $file=$request->file('photo');
                    $ext=$file->getClientOriginalExtension();
                    $filename=time().'.'.$ext;
                    $file->move('public/assets/uploads/Profile/TripAgent/profile/',$filename);
                    $image=$filename;
                }
                $agency_countries=[];
                $countries=null;
                if(isset($request->countries) && $request->countries !==Null)
                {
                   
                  foreach($request->countries as $key=>$country)
                  {
                    array_push($agency_countries,$country);
                  }
                  $countries=json_encode($agency_countries,JSON_UNESCAPED_UNICODE);
                }
                else
                {
                    $countries=null;
                }
          
                $user=Tripagent::create([
                      'name'=>$request->name,
                      'phone'=>$request->phone,
                      'password'=>bcrypt($request->password),
                      'verified_at'=>null,
                      'type'=>'Tourism_Company',
                      'address'=>$request->address,
                      'Agency_id'=>$request->agency_id,
                     'Commercial_RegistrationNo'=>$Commercial_Regist,
                     'CommercialRegistration_ExpiryDate'=>$CommRegist_ExpiryDate,
                     'license_number'=>$license_number,
                     'license_expiry_date'=>$license_expirydate,
                     'profile_photo'=>$image,
                     'Countries'=>$countries,
                     'starnumber'=>5,
                  ]);
                $verfication['user_id']=$user->id;
                  $verfication_data=$this->sms_sevices->setTripagent_VerficationCode($verfication);
                 // dd($verfication_data->otpcode);
                  $message= $this->sms_sevices->getSMSVerifyMessageByAppName($verfication_data->otpcode);
                  $sms2=$this->sms_sevices->sendSms($user->phone,$message);
                  
          //send to user mobile by smsgetway
              DB::commit();
                return response()->json([
              'message' => 'User successfully registered',
              'user' => $user
          ], 201);
              }
              catch(\Exception $ex){
                  DB::rollBack();
                  return response()->json([
                      'message' => $ex,
                      'user' => 'd'
                  ], 404);
              }


    }

    public function Activeuser(Request $request)
    {
        $data = Validator::make($request->all(), [
            'otpcode' => 'required|string|max:255|exists:tripagent_verfications',
             'user_id'=>'required|exists:tripagent_verfications'
        ]);
        if($data->fails()){
            return response()->json($data->errors()->toJson(), 400);
        }
       
        $check=$this->sms_sevices->checkOtpCode_Trpagent($request->otpcode,$request->user_id);
        if(!$check)
        {
            return response()->json([
                'message' => 'Otp not corrected',
            ], 405);
        }
        else{
			  $this->sms_sevices->removeOtpCode_Tripagent($request->otpcode);
              return response()->json([
                'message' => 'user activeted can login on system but not do anyting after enabled frm admin',
            ], 201);
        }

    }

    public function resendotp(Request $request)
    {

        $data = Validator::make($request->all(), [
            'phone' => 'required|exists:trip_agents',
        ]);
        if($data->fails()){
            return response()->json($data->errors()->toJson(), 400);
        }
    try 
        {
            DB::beginTransaction(); 
      
        $user=Tripagent::where('phone',$request->phone)->first();
        $user->update([
            'verified_at'=>Null
        ]);

        $uservervifaction=Tripagent_verfication::where('user_id',$user->id)->delete();

        //resend otp
                $verfication=[];
                $verfication['user_id']=$user->id;
                $verfication_data=$this->sms_sevices->setTripagent_VerficationCode($verfication);

                //sendsms
                $message= $this->sms_sevices->getSMSVerifyMessageByAppName($verfication_data->otpcode);
                $sms2=$this->sms_sevices->sendSms($user->phone,$message);
         //resend otp

              DB::commit();
            return response()->json([
            'message' => 'User successfully ResendOtp',
            'user' => $user
        ], 201);
            }
            catch(\Exception $ex){
                DB::rollBack();
                return response()->json([
                    'message' => $ex,
                    'user' => ''
                ], 404);
            }
     


    }
    

    public function resetpassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'otpcode' => 'required|exists:tripagent_verfications',
            'phone' => 'required|exists:trip_agents',
            'password' => ['required','min:8','confirmed', Rules\Password::defaults()],
        ]);
        if($data->fails()){
            return response()->json($data->errors()->toJson(), 400);
        }
        
    try 
        {
            DB::beginTransaction(); 
                $user=DB::table('trip_agents')->where('phone',$request->phone)
                     ->update([
                    'password'=>bcrypt($request->password),
                    'verified_at'=>now(),
                ]);
                if($user)
                {
                    $userid=Tripagent::where('phone',$request->phone)->select('id')->first();
                    $otp=$request->otpcode;
                    $uservervifaction=Tripagent_verfication::where(function($query) use($otp,$userid){
                            $query->wherein('user_id',$userid)
                                   ->where('otpcode',$otp);
                    })->delete();
                }
                DB::commit();
                return response()->json([
                    'message' => 'User successfully RestPassword',
                    'user' => $user
                ], 201);
           
            }
            catch(\Exception $ex)
            {
                DB::rollBack();
                return response()->json([
                    'message' => $ex,
                    'user' => 'd'
                ], 404);
            }
     

    }

    public function agency_types($lang)
    {
      $lang=strtolower($lang);
       $agency=AgencyType::select('id',"name->$lang as agency_name")
       ->where('status','Active')->get();
        if($agency)
        {
            return $this->apiResponse($agency,'ok',200);

        }
        else
        {
            return $this->apiResponse($agency,'ok',200);

        }

   
    }

}
