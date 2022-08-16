<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tripagent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\SelectType;
use App\Models\SelectTypeEelements;
use App\Support\Collection;
use Carbon\Carbon;
use App\Models\UserNotification;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    use ApiResponseTrait;
   //restpassword
public function resetpassword(Request $request)
{
   $user_id=Auth::user()->id;
   $oldpassword=Auth::user()->password;

    $data = Validator::make($request->all(), [
        'current_password' => 'required',
         'new_password'=> ['required','string','min:3','max:10'],
         'password_confirm'=>'required|same:new_password|string|min:3|max:10',

   ]);
   if($data->fails()){
       return response()->json($data->errors(), 400);
   }
    $currentpassword=$request->current_password;
    if(password_verify($currentpassword,$oldpassword))
    {
        $user=DB::table('trip_agents')->where('id',$user_id)->update([
         'password'=>bcrypt($request->new_password),
         'updated_at'=>now(),
       ]);
       return $this->apiResponse("Success",'Password Updated',200);
    }
    else  
    return $this->apiResponse("Error",'Current Pasword Not Correct',400);

}
//resetpassword

public function userprofile($lang)
{
  $lang=strtolower($lang);
  // return Auth::user(); //get all user data
  // return auth()->user()->id;
   //   return Auth::user()->id;
   $tripagent=Auth::user();
   $urlhost=request()->getHttpHost();
  // $user=auth()->user();
   $user['id']=$tripagent->id;
   $user['name']=$tripagent->name;
   $user['phone']=$tripagent->phone;
   $user['address']=$tripagent->address;
   $user['starnumber']=$tripagent->starnumber;
   $user['evaulation']=$tripagent->evaulation;
   $user['Agency_id']=$tripagent->Agency_id;
   if($tripagent->Agency_id==null)
   {
    $user['Agency_name']=null;
   }
   else  $user['Agency_name']=$tripagent->Agency->name;
  
   $user['Countries']=json_decode($tripagent->countries);
   $user['Commercial_RegistrationNo']=$tripagent->Commercial_RegistrationNo;
   $user['CommercialRegistration_ExpiryDate']=$tripagent->CommercialRegistration_ExpiryDate;
   $user['license_number']=$tripagent->license_number;
   $user['license_expiry_date']=$tripagent->license_expiry_date;
   $user['status']=$tripagent->status;
   $user['Coverage_areas']=[];
   foreach(json_decode($tripagent->Coverage_areas) as $key=>$Coverage_area)
   {
    $Coverage=SelectTypeEelements::select("name->$lang as Coverage_area")
       ->where('id',$Coverage_area)->first();
       $user['Coverage_areas'][$key]=$Coverage->Coverage_area;
   }
   // $user['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/".auth()->user()->photo;
   $photo=$tripagent->photo;
   if(!$photo==null)
   {
     $user['photo']="$urlhost/public/assets/uploads/Profile/TripAgent/".$tripagent->photo;
   }
   else
   {
       $user['photo']="$urlhost/public/assets/uploads/Profile/TripAgent/".'defaultimage.jpg';
   }
   $photo_profile=$tripagent->profile_photo;
   if(!$photo_profile==null)
   {
     $user['photo_profile']="$urlhost/public/assets/uploads/Profile/TripAgent/profile/".$tripagent->profile_photo;
   }
   else
   {
       $user['photo_profile']="$urlhost/public/assets/uploads/Profile/TripAgent/profile/".'defaultimage.jpg';
   }
   $user['verified_at']=$tripagent->verified_at;
   $user['created_at']=$tripagent->created_at;
   $user['updated_at']=$tripagent->updated_at;
   return response()->json($user);
}
  public function updateuser(Request $request)
  {
      $currentuser=auth()->user();
      //return response($currentuser);
      $user_id=$currentuser->id;
    $data = Validator::make($request->all(), [
      'name' => 'required|string|max:255|',
      'phone' => 'required|unique:trip_agents,phone,'.$user_id,

      'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg',

      ]);
    if($data->fails()){
        return response()->json($data->errors(), 400);
    }
  try
  {
    DB::beginTransaction();
    // $image=$user->photo;
    //$currentuser=User::findorfail($request->user_id);
    $image=$currentuser->photo;
    $rand=mt_rand(100000,999999);
       //return response($image);

     if($request->hasfile('profile_photo')) 
     {
         //هشيل الصورة الديمة
         $path='public/assets/uploads/Profile/TripAgent/profile/'.$image;
         if(File::exists($path))
          {
              File::delete($path);
          }  
        
          $file=$request->file('profile_photo');
          $ext=$file->getClientOriginalExtension();
          $filename=$rand.'.'.$ext;
          $file->move('assets/uploads/Profile/TripAgent/profile',$filename);
          $image=$filename;
     }
     if(isset($request->desc) && $request->desc !==Null)$desc=['en'=>$request->desc,'ar'=>$request->desc];else $desc=$currentuser->desc;
     if(isset($request->Coverage_areas) && $request->Coverage_areas !==Null)$Coverage_areas=$request->Coverage_areas;else $Coverage_areas=$currentuser->Coverage_areas;



     
     
     $user=Tripagent::where('id',$currentuser->id)->update([
         'name'=>$request->name,
         'phone'=>$request->phone,
         'verified_at'=>$currentuser->verified_at,
         'photo'=>$image,
         'desc'=>$desc,
         'Coverage_areas'=>json_encode($Coverage_areas,JSON_UNESCAPED_UNICODE),
         
     ]);

     DB::commit();
     return $this->apiResponse('user updated','ok',200);
 }
 catch(\Exception $ex){
   return $this->apiResponse($ex,'Failed To Update',404);
  }
  }
  public function show_Coverageareas($lang)
  {
    $data=SelectTypeEelements::select('id',"name->$lang as Coverage_area")
         ->where('selecttype_id',18)->get();
    return $this->apiResponse($data,'ok',200);

  }
}
