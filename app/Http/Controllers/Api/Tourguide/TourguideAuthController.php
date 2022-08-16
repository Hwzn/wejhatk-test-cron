<?php

namespace App\Http\Controllers\Api\Tourguide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\TourGuide;
// use App\Models\Tripagent_verfication;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
use App\Http\Services\SMSServices;
use App\Models\AgencyType;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\Booking;
use App\Models\Tourguide_verfication;
use App\Models\Tripagent;

class TourguideAuthController extends Controller
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


   

    public function register(Request $request)
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

    public function Activeuser(Request $request)
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

    public function resendotp(Request $request)
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
    

    public function resetpassword(Request $request)
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


    public function getall_tripagents()
    {
       return response()->json('ddd');
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

    public function getusers()
    {
        $urlhost=request()->getHttpHost();
        $tourguide_id=Auth::user()->id;

        $data=Booking::select('bookings.User_id','users.id','users.name','users.photo')
                  ->where('Tourguide_id',$tourguide_id)
                  ->join('users','users.id','=','bookings.User_id')
                   ->where('User_id','!=',null)->distinct()->get();
      $users_data=[];
     if(!empty($data))
        {
            foreach($data as $user)
            {
               $array['id']=$user->id;
               $array['name']=$user->name;
               $photo=$user->photo;
               if(!$photo==null)
               {
                $array['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/".$photo;
               }
               else
               {
                $array['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/defaultimage.jpg";
               }
               array_push($users_data,$array);
            }
        }
    if($users_data)
    {
     return $this->apiResponse($users_data,'ok',200);
    }
    else
    {
        return $this->apiResponse([],'no data found',404);

    }
    }
    public function delete_user()
    {
     // return response('dddd');
      $user_id=Auth::user()->id;
      $user_data=TourGuide::where('id',$user_id)->delete();
      if($user_data)
    {
     return $this->apiResponse($user_data,'user deleted',200);
    }
    else
    {
        return $this->apiResponse([],'error in delete user',404);
  
    }
    }
}
