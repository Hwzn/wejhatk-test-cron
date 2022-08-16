<?php

namespace App\Http\Controllers\Api\Tourguide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\TourGuide;
use App\Models\Tripagent;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;


class Tour_ProfileController extends Controller
{
    use ApiResponseTrait;
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
            $user=DB::table('tour_guides')->where('id',$user_id)->update([
             'password'=>bcrypt($request->new_password),
             'updated_at'=>now(),
           ]);
           return $this->apiResponse("Success",'Password Updated',200);
        }
        else  
        return $this->apiResponse("Error",'Current Pasword Not Correct',400);
    
    }
    
    public function userprofile()
    {
       
       $tourguide=Auth::user();
       $urlhost=request()->getHttpHost();
      // $user=auth()->user();
       $user['id']=$tourguide->id;
       $user['name']=$tourguide->name;
       $user['phone']=$tourguide->phone;
       $user['address']=$tourguide->address;
       $user['starnumber']=$tourguide->starnumber;
       $user['Countries']=json_decode($tourguide->Countries);
       $user['Commercial_RegistrationNo']=$tourguide->commercial_registrationNo;
       $user['CommercialRegistration_ExpiryDate']=$tourguide->commercialregistration_expiryDate;
       $user['license_number']=$tourguide->license_number;
       $user['license_expiry_date']=$tourguide->license_expiry_date;
       $user['status']=$tourguide->status;
       $user['desc']=$tourguide->desc;
       $user['cv']=$tourguide->cv;    
       // $user['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/".auth()->user()->photo;
       $photo=$tourguide->photo;
       if(!$photo==null)
       {
         $user['photo']="$urlhost/public/assets/uploads/Profile/TourGuide/Tripbackground/".$tourguide->photo;
       }
       else
       {
           $user['photo']="$urlhost/public/assets/uploads/Profile/TourGuide/Tripbackground/".'defaultimage.jpg';
       }
       $photo_profile=$tourguide->profile_photo;
       if(!$photo_profile==null)
       {
         $user['photo_profile']="$urlhost/public/assets/uploads/Profile/TourGuide/".$tourguide->profile_photo;
       }
       else
       {
           $user['photo_profile']="$urlhost/public/assets/uploads/Profile/TourGuide/".'defaultimage.jpg';
       }
       if($tourguide->tripagent_id==null)
       {
        $user['tripagent_data']=[];
       }
       else
       {
        $tripagent=Tripagent::select('name')->where('id',$tourguide->tripagent_id)->first();
         $user['tripagent_name']=$tripagent->name;
       }
       $cv=$tourguide->cv;
       if(!$cv==null)
       {
         $user['cv']="$urlhost/public/assets/uploads/Profile/TourGuide/CV/".$tourguide->cv;
       }
       else
       {
           $user['cv']=[];
       }
       $user['verified_at']=$tourguide->verified_at;
       $user['created_at']=$tourguide->created_at;
       $user['updated_at']=$tourguide->updated_at;
       return response()->json($user);
    }
      public function updateuser(Request $request)
      {
          $currentuser=auth()->user();
          $user_id=$currentuser->id;
          $data = Validator::make($request->all(), [
            'name' => 'required|string|max:255|',
            'phone' => 'required|unique:tour_guides,phone,'.$user_id,
             // 'phone'=>Rule::unique('tour_guides')->where(function ($query) use($user_id) {
             //  return $query->where('id','!=',$user_id);
             // }),
            'tripagent_id' => 'exists:trip_agents,id',
            'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg',
            'CV'=>'mimes:pdf,docx|max:2048',
 
          ]);
        if($data->fails()){
            return response()->json($data->errors(), 400);
        }
      try
      {
        DB::beginTransaction();
        // $image=$user->photo;
        //$currentuser=User::findorfail($request->user_id);
        $image=$currentuser->profile_photo;
        $cv=$currentuser->cv;
        $rand=mt_rand(100000,999999);
           //return response($image);
    
         if($request->hasfile('profile_photo')) 
         {
             //هشيل الصورة الديمة
             $path='assets/uploads/Profile/TourGuide/'.$image;
             if(File::exists($path))
              {
                  File::delete($path);
              }  
            
              $file=$request->file('profile_photo');
              $ext=$file->getClientOriginalExtension();
              $filename=$rand.'.'.$ext;
              $file->move('assets/uploads/Profile/TourGuide',$filename);
              $image=$filename;
         }
         if($request->hasfile('cv')) 
         {
             //هشيل الصورة الديمة
             $path='assets/uploads/Profile/TourGuide/CV/'.$cv;
             if(File::exists($path))
              {
                  File::delete($path);
              }  
            
              $file=$request->file('cv');
              $ext=$file->getClientOriginalExtension();
              $filename=$rand.'.'.$ext;
              $file->move('assets/uploads/Profile/TourGuide/CV',$filename);
              $cv=$filename;
         }

        //  if(isset($request->address) && $request->address !==Null)$address=$request->address;else $address=$currentuser->address;
        if(isset($request->tripagent_id) && $request->tripagent_id !==Null)$tripagent_id=$request->tripagent_id;else $tripagent_id=$currentuser->tripagent_id;
        if(isset($request->desc) && $request->desc !==Null)$desc=['en'=>$request->desc,'ar'=>$request->desc];else $desc=$currentuser->desc;    
               if(isset($request->countries) && $request->countries !==Null)$countries=$request->countries;else $countries=$currentuser->Countries;

    
    
         
         
         $user=TourGuide::where('id',$currentuser->id)->update([
             'name'=>$request->name,
             'phone'=>$request->phone,
             'verified_at'=>$currentuser->verified_at,
             'profile_photo'=>$image,
             'countries'=>json_encode($countries,JSON_UNESCAPED_UNICODE),
              'address'=>null,
              'tripagent_id'=>$tripagent_id,
              'desc'=>$desc,
              'cv'=>$cv,
            
         ]);
    
         DB::commit();
        
         return $this->apiResponse($user,'ok',200);
     }
     catch(\Exception $ex){
       return $this->apiResponse($ex,'Failed To Update',404);
      }
      }
}
