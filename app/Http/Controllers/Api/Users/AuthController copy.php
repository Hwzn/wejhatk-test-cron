<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\SMSServices;
use App\Models\TourGuide;
use App\Models\Tourguide_verfication;
use App\Models\Tripagent;
use App\Models\Tripagent_verfication;
use App\Models\User_verfication;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
// require_once '/path/to/vendor/autoload.php';
use Twilio\Rest\Client;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\AgencyType;
use App\Models\Country;

use function Symfony\Component\VarDumper\Dumper\esc;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public $sms_sevices;
    public function __construct(SMSServices $sms_sevices) {
        $this->middleware('auth:api', ['except' => ['login', 'register','resendotp','resetpassword','Activeuser','delete_user','getall_tripagents','agency_types','countires']]);
        $this->sms_sevices=$sms_sevices;

    }

    public function login(Request $request){
       if($request->guardkey=='user_1')
       {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|string|min:6',
            'device_token'=>'required',
        ]);
        // fffsllgglglglsssssssssssssssssssslgglgllgglllllllllllllllllllllllllllllllllg
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       $user=User::where('phone',$request->phone)->first();
    //    return response($user);
       if($user)
       {
           if($user->verified_at==Null)
           {
            return response()->json(['error' => 'User Not Activated'], 401);

           }
       }
        // if (! $token = auth()->attempt($validator->validated())) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        if (! $token = auth()->attempt(['phone'=>$request->phone,
                 'password'=>$request->password]))
         {
                   return response()->json(['error' => 'Unauthorized'], 401);
         }
      
          //send device token
         $exists=$user->DeviceTokens()
        ->where('token','=',$request->device_token)->exists();
        if(!$exists)
        {
            $user->DeviceTokens()->create([
                'token'=>$request->device_token,
            ]);
        } 
        //send device token
 
        return $this->createNewToken($token,$request->guardkey);

       }
       elseif($request->guardkey=='tripagent_1')
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
             $tripagent->guardkey='tripagent_1';

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
       elseif($request->guardkey=='tourguide_1')
       {

        try{
            //valdtion
             $rules=[
                 "phone"=>'required|exists:tour_guides,phone',
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
             $token=Auth::guard('tourguide-api')->attempt($credantionals);
             if(!$token)
                 return response()->json(['error' => 'invalid username or password'], 401);
 
             $tourguide=Auth::guard('tourguide-api')->user();
           // return response($tourguide);
           if($tourguide->verified_at==Null)
            {
             return response()->json(['error' => 'User Not Activated'], 401);
            }
             $tourguide->api_token=$token;
             $tourguide->expires_in= auth()->factory()->getTTL() * 2313113;
             $tourguide->guardkey='tourguide_1';
           //  return response($tourguide);
 
         //send device token
             $exists=$tourguide->DeviceTokens()
             ->where('token','=',$request->device_token)->exists();
 
             if(!$exists)
             {
            // return response('ddddd');
 
                 $tourguide->DeviceTokens()->create([
                     'token'=>$request->device_token,
                 ]);
             } 
          //send device token
       //   return response()->json('fff');
 
             return response()->json(['User_data' => $tourguide], 200);
 
        }
         catch(\Exception $ex)
         {
             return response()->json([
                 'message' => $ex,
                 'user' => 'd'
             ], 404);
         }
        
       }
       else{
        return response()->json(['error'=>'no guard key found']);

       }

    
       
      
    }

    public function register(Request $request) 
    {

       if($request->guardkey=='user_1')
       {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            // 'phone' => 'required|string|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'photo'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        //for if user not write otp for any reson and want to repeat register
        if(User::where('phone',$request->phone)->exists())
        {
           $user=User::where('phone',$request->phone)->first();
           User_verfication::where('user_id',$user->id)->delete();
           User::where('id',$user->id)->delete();
        }
     try 
        {
            DB::beginTransaction(); 
            $verfication=[];
            $user=User::create([
                    'name'=>$request->name,
                    'phone'=>$request->phone,
                    'password'=>bcrypt($request->password),
                    'verified_at'=>null,
                    // 'photo'=>$filename,
                ]);
                $verfication['user_id']=$user->id;
                $verfication_data=$this->sms_sevices->setVerficationCode($verfication);
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

        elseif($request->guardkey=="tripagent_1")
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
                       
                         $countries=json_encode($request->countries,JSON_UNESCAPED_UNICODE);
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
                    //  'Countries'=>json_encode($country,JSON_UNESCAPED_UNICODE),
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
        elseif($request->guardkey=='tourguide_1')
        {
            $rules=[
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                // 'address' => 'required|string|max:255',
                'tripagent_id' => 'exists:trip_agents,id',
                // 'phone' => 'required|string|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                // 'countries' => 'required|exists:countries,id',
                'photo'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
                'commercial_registrationNo'=> 'numeric|digits:10|unique:tour_guides,commercial_registrationNo',
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
           if(TourGuide::where('phone',$request->phone)->exists())
              {
                $user=TourGuide::where('phone',$request->phone)->first();
                 if($user->verified_at==null)
                 {
                    //delete old image if found
                    $image=$user->profile_photo;
                    $path="public/assets/uploads/Profile/TourGuide/".$image;
    
                    if(File::exists($path))
                    {
                        File::delete($path);
                    }  
                    Tourguide_verfication::where('user_id',$user->id)->delete();
                    TourGuide::where('id',$user->id)->delete();
                   
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
                   // if(isset($request->countries) && $request->countries !==Null) $countries=json_encode($request->countries,JSON_UNESCAPED_UNICODE); else $countries=null;
                    if(isset($request->tripagent_id) && $request->tripagent_id !==Null) $tripagent_id=$request->tripagent_id; else $tripagent_id=null;
    
                    
                    if($request->hasfile('photo')) 
                    {
                        $file=$request->file('photo');
                        $ext=$file->getClientOriginalExtension();
                        $filename=time().'.'.$ext;
                        $file->move('assets/uploads/Profile/TourGuide/',$filename);
                        $image=$filename;
                    }
                
                    $countries=null;
                  
                    if(isset($request->countries) && $request->countries !==Null)
                    {
                       
                         $countries=json_encode($request->countries,JSON_UNESCAPED_UNICODE);
                    }
                    else
                    {
                        $countries=null;
                    }

                    $user=TourGuide::create([
                          'name'=>$request->name,
                          'phone'=>$request->phone,
                          'password'=>bcrypt($request->password),
                          'verified_at'=>null,
                          'address'=>null,
                          'tripagent_id'=>$tripagent_id,
                         'commercial_registrationNo'=>$Commercial_Regist,
                         'commercialregistration_expiryDate'=>$CommRegist_ExpiryDate,
                         'license_number'=>$license_number,
                         'license_expiry_date'=>$license_expirydate,
                         'profile_photo'=>$image,
                         'Countries'=>$countries,
                         'starnumber'=>0,
                         'status'=>'not_active',
                      ]);
                    $verfication['user_id']=$user->id;
                      $verfication_data=$this->sms_sevices->setTurguide_VerficationCode($verfication);
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
        else
        {
            return response()->json(['error'=>'no guard key found']);
        }
    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    // public function refresh() {
    //     return $this->createNewToken(auth()->refresh());
    // }

    public function userProfile() {
        $urlhost=request()->getHttpHost();
            $user=auth()->user();
             $user['id']=auth()->user()->id;
            $user['name']=auth()->user()->name;
            $user['phone']=auth()->user()->phone;
            // $user['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/".auth()->user()->photo;
            $photo=auth()->user()->photo;
            if(!$photo=='')
            {
              $user['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/".auth()->user()->photo;
            }
            else
            {
                $user['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/".'defaultimage.jpg';
            }
            
            $user['verified_at']=auth()->user()->verified_at;
            $user['created_at']=auth()->user()->created_at;
            $user['updated_at']=auth()->user()->updated_at;
        return response()->json($user);
    }
    protected function createNewToken($token,$guard){
        $urlhost=request()->getHttpHost();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'expires_in' => auth()->factory()->getTTL() * 60,
            $user['id']=auth()->user()->id,
            $user['name']=auth()->user()->name,
            $user['phone']=auth()->user()->phone,
            $user['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/".auth()->user()->photo,
            $user['verified_at']=auth()->user()->verified_at,
            $user['created_at']=auth()->user()->created_at,
            $user['updated_at']=auth()->user()->updated_at,
            $user['guard_key']=$guard,
           
            'user' => $user

        ]);
    }

    public function Activeuser(Request $request)
    {
       if($request->guardkey=='user_1')
       {
        $data = Validator::make($request->all(), [
            'otpcode' => 'required|string|max:255|exists:users_verficationcode',
            'user_id'=>'required|exists:users_verficationcode'
        ]);

        if($data->fails()){
            return response()->json($data->errors()->toJson(), 400);
        }
       
        $check=$this->sms_sevices->checkOtpCode($request->otpcode,$request->user_id);
        if(!$check)
        {
            return response()->json([
                'message' => 'Otp not corrected',
            ], 405);
        }
        else{
			  $this->sms_sevices->removeOtpCode($request->otpcode);
              return response()->json([
                'message' => 'user activeted',
            ], 201);
        }

       }
       elseif($request->guardkey=='tripagent_1')
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
       elseif($request->guardkey=='tourguide_1')
       {
        $data = Validator::make($request->all(), [
            'otpcode' => 'required|string|max:255|exists:tourguide_verfications',
             'user_id'=>'required|exists:tourguide_verfications'
        ]);
        if($data->fails()){
            return response()->json($data->errors(), 400);
        }
       
        $check=$this->sms_sevices->checkOtpCode_Tourguide($request->otpcode,$request->user_id);
        if(!$check)
        {
            return response()->json([
                'message' => 'Otp not corrected',
            ], 405);
        }
        else{
			  $this->sms_sevices->removeOtpCodeTourguide($request->otpcode);
              return response()->json([
                'message' => 'user activeted can login on system but not do anyting after enabled from admin',
            ], 201);
        }
       }
       else
       {
           return response()->json(['error'=>'no guard key found']);
       }
       

    }


    public function resendotp(Request $request)
    {
       if($request->guardkey=='user_1')
       {
        $data = Validator::make($request->all(), [
            'phone' => 'required|exists:users',
        ]);
        if($data->fails()){
            return response()->json($data->errors()->toJson(), 400);
        }
    try 
        {
            DB::beginTransaction(); 
      
        $user=User::where('phone',$request->phone)->first();
        $user->update([
            'verified_at'=>Null
        ]);

        $uservervifaction=User_verfication::where('user_id',$user->id)->delete();

        //resend otp
                $verfication=[];
                $verfication['user_id']=$user->id;
                $verfication_data=$this->sms_sevices->setVerficationCode($verfication);

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

       elseif($request->guardkey=='tripagent_1')
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
        elseif($request->guardkey=='tourguide_1')
       {
        $data = Validator::make($request->all(), [
            'phone' => 'required|exists:tour_guides',
        ]);
        if($data->fails()){
            return response()->json($data->errors()->toJson(), 400);
        }
    try 
        {
            DB::beginTransaction(); 
      
        $user=TourGuide::where('phone',$request->phone)->first();
        $user->update([
            'verified_at'=>Null
        ]);

        $uservervifaction=Tourguide_verfication::where('user_id',$user->id)->delete();

        //resend otp
                $verfication=[];
                $verfication['user_id']=$user->id;
                $verfication_data=$this->sms_sevices->setTurguide_VerficationCode($verfication);
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

       else{

        return response()->json(['error'=>'no guard key found']);

       }

    }
    
    public function resetpassword(Request $request)
    {
       if($request->guardkey=='user_1')
       {
        $data = Validator::make($request->all(), [
            'otpcode' => 'required|exists:users_verficationcode',
            'phone' => 'required|exists:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if($data->fails()){
            return response()->json($data->errors()->toJson(), 400);
        }
        
    try 
        {
            DB::beginTransaction(); 
                $user=DB::table('users')->where('phone',$request->phone)
                     ->update([
                    'password'=>bcrypt($request->password),
                    'verified_at'=>now(),
                ]);
                if($user)
                {
                    $userid=User::where('phone',$request->phone)->select('id')->first();
                    $otp=$request->otpcode;
                    $uservervifaction=User_verfication::where(function($query) use($otp,$userid){
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
       elseif($request->guardkey=='tripagent_1')
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
       elseif($request->guardkey=='tourguide_1')
       {
        $data = Validator::make($request->all(), [
            'otpcode' => 'required|exists:tourguide_verfications',
            'phone' => 'required|exists:tour_guides',
            'password' => ['required','min:8', 'confirmed', Rules\Password::defaults()],
        ]);
        if($data->fails()){
            return response()->json($data->errors(), 400);
        }
        
    try 
        {
            DB::beginTransaction(); 
                $user=DB::table('tour_guides')->where('phone',$request->phone)
                     ->update([
                    'password'=>bcrypt($request->password),
                    'verified_at'=>now(),
                ]);
                if($user)
                {
                    $userid=TourGuide::where('phone',$request->phone)->select('id')->first();
                    $otp=$request->otpcode;
                    $uservervifaction=Tourguide_verfication::where(function($query) use($otp,$userid){
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

       else
       {
        return response()->json(['error'=>'no guard key found']);

       }
       

    }

    public function delete_user($id)
    {
       // return response()->json($id);
        $data=User::findorfail($id)->delete();
        if($data)
        {
            return response()->json([
                'message' => 'User successfully Deleted',
                'user' => $data
            ], 201);
        }
        else{
            return response()->json([
                'message' => ' Error in  DeletedUser',
                'data' => $data
            ], 405);
        }
    }

    public function getall_tripagents()
    {
       
            $data=Tripagent::select('id','name','agency_id')
                  ->where('status','active')->get();
            if($data)
             {
              return $this->apiResponse($data,'ok',200);
             }
             else
             {
                 return $this->apiResponse([],'no data found',404);
 
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

    public function countires($lang)
    {
      $lang=strtolower($lang);
       $countires=Country::select('id',"name->$lang as country_name")
       ->where('status','Active')->get();
        if($countires)
        {
            return $this->apiResponse($countires,'ok',200);

        }
        else
        {
            return $this->apiResponse([],'no data found',400);

        }

   
    }
}
