<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\SMSServices;
use App\Models\User_verfication;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
// require_once '/path/to/vendor/autoload.php';
use Twilio\Rest\Client;

use function Symfony\Component\VarDumper\Dumper\esc;

class AuthController extends Controller
{
    public $sms_sevices;
    public function __construct(SMSServices $sms_sevices) {
        $this->middleware('auth:api', ['except' => ['login', 'register','resendotp','resetpassword','Activeuser','delete_user']]);
        $this->sms_sevices=$sms_sevices;

    }

    public function login(Request $request){
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
         }z
      
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
 
        return $this->createNewToken($token);

       
      
    }

    public function register(Request $request) {

        
        
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

        //     //for photo add
        //     if($request->hasfile('photo')) 
        //     {
        //         $file=$request->file('photo');  
        //         $ext=$file->getClientOriginalExtension(); 
        //         $filename=time().'.'.$ext;
        //         $file->move('assets/uploads/Profile/UserProfile',$filename);
        //    }
            //for photo add
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
    protected function createNewToken($token){
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

           
            'user' => $user

        ]);
    }

    public function Activeuser(Request $request)
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


    public function resendotp(Request $request)
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
    
    public function resetpassword(Request $request)
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
}
