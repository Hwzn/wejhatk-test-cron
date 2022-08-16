<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Serivce;
use App\Models\Tripagent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\AdsSlideShow;
use App\Models\Booking;
use App\Models\PlacesToVisit;
use App\Models\ServiceAttruibute;
use App\Models\TermsandCondition;
use App\Models\TourGuide;
use App\Models\TripagentsService;
use App\Models\UsagePolicy;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Attribute;
use App\Models\CarType;
use App\Models\UserNotification;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class UserController extends Controller
{
    use ApiResponseTrait;
    
public function updateuser(Request $request)
{

    $data = Validator::make($request->all(), [
         'user_id'=>'required|exists:users,id',
         'name' => 'required|string|max:255|',
         'phone' => 'required|string|unique:users,phone,'.$request->user_id,
         //  'password' => ['required', 'confirmed', Rules\Password::defaults()],
          'photo'=>'image|mimes:jpg,png,jpeg,gif,svg',
    ]);
    if($data->fails()){
        return response()->json($data->errors()->toJson(), 400);
    }
    try{
       DB::beginTransaction();
       // $image=$user->photo;
     $currentuser=User::findorfail($request->user_id);
     $image=$currentuser->photo;
     
        if($request->hasfile('photo')) 
        {
            //هشيل الصورة الديمة
            $path='public/assets/uploads/Profile/UserProfile/'.$image;
            if(File::exists($path))
             {
                 File::delete($path);
             }  
           
             $file=$request->file('photo');
             $ext=$file->getClientOriginalExtension();
             $filename=time().'.'.$ext;
             $file->move('public/assets/uploads/Profile/UserProfile',$filename);
             $image=$filename;
        }
    
        $user=User::findorfail($request->user_id)->update([
            'name'=>$request->name,
            'phone'=>$request->phone,
            // 'password'=>bcrypt($request->password),
            'verified_at'=>$currentuser->verified_at,
            'photo'=>$image,
        ]);

        DB::commit();
        return response()->json([
                    'message' => 'User successfully Updated',
                    'user' => $user
                ], 201);
                    
    
    }
    catch(\Exception $ex){
        DB::rollBack();
        return response()->json([
            'message' => $ex,
            'user' => 'Error in update'
        ], 404);
    }

    // return response()->json($user);
}

//restpassword
public function resetpassword(Request $request)
{
    $data = Validator::make($request->all(), [
      'user_id'=>'required|exists:users,id',
      'current_password' => 'required',
         'new_password'=> ['required','string','min:3','max:10'],
         'password_confirm'=>'required|same:new_password|string|min:3|max:10',

   ]);
   if($data->fails()){
       return response()->json($data->errors(), 400);
   }
    $current_user=User::findorfail($request->user_id);
    $currentpassword=$request->current_password;
    if(password_verify($currentpassword,$current_user->password))
    {
        $user=DB::table('users')->where('id',$current_user->id)->update([
         'password'=>bcrypt($request->new_password),
         'updated_at'=>now(),
       ]);
       return response()->json([
           'message'=>'password updated',
           'data'=>$user,
       ],201);

    }
    else   return response()->json('Password User Entered Is Incorrect');

}
//resetpassword
    public function userhomepage($lang)
    {

      
      $urlhost=request()->getHttpHost();
     //ads
     $AdsSlideShows=AdsSlideShow::where('status','enabled')
     ->orderby('id','desc')
     ->take(4)
         ->get();
      $data['$AdsSlide']=array();
      foreach($AdsSlideShows as $AdsSlideShow)
      {
      $array_s['id']=$AdsSlideShow->id;
      $array_s['photo']="$urlhost/assets/uploads/AdsSlideShow/".$AdsSlideShow->photo;
      $array_s['status']=$AdsSlideShow->status;
      array_push($data['$AdsSlide'],$array_s);
      }

     //ads
      $services=Serivce::select('id',"name->$lang as service_name",'photo')
                        ->where('status','active')
                        ->orderby('id','asc')->get();
      $data['services']=array();
                        foreach($services as $service)
                        {
                           $array_se['id']=$service->id;
                           $array_se['service_name']=$service->service_name;
                           $array_se['photo']="$urlhost/assets/uploads/Services/".$service->photo;
                           array_push($data['services'],$array_se);
                        }
     //tripagents
       $tripagents=Tripagent::select('id',"name->$lang as Tripagent_Name",'photo','starnumber','profile_photo')
                          ->where('type','Tourism_Company')
                          ->where('verified_at',"!=",Null)
        ->orderby('id','desc')->take(4)->get();
    
  
        $data['tripagents']=array();
        foreach($tripagents as $tripagent)
        {
           $array['id']=$tripagent->id;
           $array['Tripagent_Name']=$tripagent->Tripagent_Name;
           $array['starnumber']=$tripagent->starnumber;
          $array['Service_id']=TripagentsService::where('tripagent_id',$tripagent->id)->pluck('service_id')->first();
          $array['photo']="$urlhost/assets/uploads/Profile/TripAgent/".$tripagent->photo;;
          $array['profile_photo']="$urlhost/assets/uploads/Profile/TripAgent/profile/".$tripagent->profile_photo;;

          array_push($data['tripagents'],$array);
        }
       // tripagents
        
      // placestovisit
        $placestovisits=PlacesToVisit::select('id',"name->$lang as PlaceVisit_Name",'photo','desc')
                          ->where('status','active')
                          ->orderby('id','desc')->take(4)->get();
        $data['placestovisit']=array();
        foreach($placestovisits as $placestovisit)
        {
           $array2['id']=$placestovisit->id;
           $array2['PlaceVisit_Name']=$placestovisit->PlaceVisit_Name;
           $array2['desc']=$placestovisit->desc;
           $array2['photo']="$urlhost/assets/uploads/PlacesToVisit/".$placestovisit->photo;
           array_push($data['placestovisit'],$array2);
         }
     //placestovisit

     //tourgudes
        $tourguides=TourGuide::select('id',"name->$lang as Tourguide_Name",'photo','starnumber')
                          ->where('verified_at',"!=",Null)
                          ->orderby('id','desc')->take(4)->get();
        $data['tourguides']=array();
                          foreach($tourguides as $tourguide)
                          {
                             $array3['id']=$tourguide->id;
                             $array3['Tourguide_Name']=$tourguide->Tourguide_Name;
                             $array3['starnumber']=$tourguide->starnumber;
                             $array3['photo']="$urlhost/assets/uploads/Profile/TourGuide/Tripbackground/".$tourguide->photo;
                             array_push($data['tourguides'],$array3);
                           }
     //tourguide

     //educational service

        $educational_services=Tripagent::select('id',"name->$lang as Tripagent_Name",'photo','starnumber','profile_photo')
                           ->where('type','educational_service')
                           ->where('verified_at',"!=",Null)
                           ->orderby('id','desc')->take(4)->get();
       $data['educational_service']=array();
        foreach($educational_services as $educational_service)
        {
           $array['id']=$educational_service->id;
           $array['Tripagent_Name']=$educational_service->Tripagent_Name;
           $array['starnumber']=$educational_service->starnumber;
           $array['photo']="$urlhost/assets/uploads/Profile/TripAgent/".$educational_service->photo;;
           $array['profile_photo']="$urlhost/assets/uploads/Profile/TripAgent/profile/".$educational_service->profile_photo;;

           array_push($data['educational_service'],$array);
        }
     //educational service

        if(!is_null($data))
        {
           return $this->apiResponse($data,'ok',200);
        }
        else{
           return $this->apiResponse("",'not data found',404);
        }

    }

    //
    public function getallTourism_tripgents($lang)
    {
      
         $data['Tripagents']=Tripagent::select('id',"name->$lang as Tripagent",'phone','photo',"desc->$lang as desc",'starnumber','profile_photo')
         ->where('type','Tourism_Company')
         ->where('verified_at','!=',Null)
        ->orderby('id','desc')->paginate(10);
         
        $TripAgent=array();
        $HostName=request()->getHttpHost();
        if($data['Tripagents']->count()>0)
        {
           foreach($data['Tripagents'] as $data)
           {
              $array['id']=$data->id;
              $array['Tripagent']=$data->Tripagent;
              $array['phone']=$data->phone;
              $array['Service_id']=TripagentsService::where('tripagent_id',$data->id)->orderby('id','desc')->pluck('service_id')->first();
              $array['photo']="$HostName/assets/uploads/Profile/TripAgent/".$data->photo;
              $array['profile_photo']="$HostName/assets/uploads/Profile/TripAgent/profile/".$data->profile_photo;
              $array['desc']=$data->desc;
              $array['starnumber']=$data->starnumber;
              array_push($TripAgent,$array);
           }
          return $this->apiResponse($TripAgent,'ok',200);
         }
        else
        {
           return $this->apiResponse("",'not data found',404);
        }

    }

   //
    public function alleducationcompany_tripgents($lang)
    {
      $data['Tripagents']=Tripagent::select('id',"name->$lang as Tripagent",'phone','photo',"desc->$lang as desc",'starnumber','profile_photo')
         ->where('type','educational_service')
         ->where('verified_at','!=',Null)
        ->orderby('id','desc')->paginate(10);
         
        $TripAgent=array();
        $HostName=request()->getHttpHost();
        if($data['Tripagents']->count()>0)
        {
           foreach($data['Tripagents'] as $data)
           {
              $array['id']=$data->id;
              $array['Tripagent']=$data->Tripagent;
              $array['phone']=$data->phone;
              $array['Service_id']=TripagentsService::where('tripagent_id',$data->id)->orderby('id','desc')->pluck('service_id')->first();
              $array['photo']="$HostName/assets/uploads/Profile/TripAgent/".$data->photo;
              $array['profile_photo']="$HostName/assets/uploads/Profile/TripAgent/profile/".$data->profile_photo;
              $array['desc']=$data->desc;
              $array['starnumber']=$data->starnumber;
              array_push($TripAgent,$array);
           }
          return $this->apiResponse($TripAgent,'ok',200);
         }
        else
        {
           return $this->apiResponse("",'not data found',404);
        }

    }

   
    public function get_tripagentbyid($lang,$id)
    {
      
         $data=Tripagent::select('id',"name->$lang as Tripagent",'phone','photo','type',"desc->$lang as desc",'starnumber','profile_photo')
         ->where('id',$id)
         ->first();
         
        $HostName=request()->getHttpHost();
         if(!$data==Null)
         {
            $array['id']=$data->id;
            $array['tripagent']=$data->Tripagent;
            $array['phone']=$data->phone;
            $array['type']=$data->type;
            $array['photo']="$HostName/assets/uploads/Profile/TripAgent/".$data->photo;
            $array['profile_photo']="$HostName/assets/uploads/Profile/TripAgent/profile/".$data->profile_photo;
            $array['desc']=$data->desc;
            $array['starnumber']=$data->starnumber;
            return $this->apiResponse($array,'ok',200);
         }
         else
         {
            return $this->apiResponse("",'not data found',404);

         }
          
             
         }
       



    public function getTripgents_byServiceid($lang,$id)
    {
    $data=Serivce::select('id',"name->$lang as Service_Name",'photo')
         ->with(['Tripagents'=>function($query) use($lang){
          $query->select('trip_agents.id',"name->$lang as Tripagent_Name",'phone','photo','starnumber','profile_photo')
             ->where('trip_agents.verified_at',"!=",Null);
    }])->find($id);
  
//return response(["data"=>$data->Tripagents]);
     $HostName=request()->getHttpHost();
        $tripagent=array();
       foreach($data->Tripagents as $tripagents)
       {
         $array['service_id']=$data->id;
            $array['service_name']=$data->Service_Name;
            $array['service_photo']="$HostName/assets/uploads/Services/".$data->photo;
            $array['Tripagent_id']=$tripagents->id;
            $array['name']=$tripagents->Tripagent_Name;
            $array['phone']=$tripagents->phone;
            $array['starnumber']=$tripagents->starnumber;
            $array['photo']="$HostName/assets/uploads/Profile/TripAgent/".$tripagents->photo;
            $array['profile_photo']="$HostName/assets/uploads/Profile/TripAgent/profile/".$tripagents->profile_photo;
            array_push($tripagent,$array);
    }
      //  {
      //       $array['service_id']=$data->id;
      //       $array['service_name']=$data->Service_Name;
      //       $array['service_photo']="$HostName/public/assets/uploads/Services/".$data->photo;
      //       $array['Tripagent_id']=$tripagents->id;
      //       $array['name']=$tripagents->Tripagent_Name;
      //       $array['phone']=$tripagents->phone;
      //       $array['photo']="$HostName/public/assets/uploads/Profile/TripAgent/".$tripagents->photo;
      //       array_push($tripagent,$array);
      //  }
        if($tripagent)
        { 
         return $this->apiResponse($tripagent,'ok',200);
        }
        else{
           return $this->apiResponse("",'No Data Found',404);
      }
    }

    public function getservices_byTripagentid($lang,$id)
    {
      $data=Tripagent::select('id',"name->$lang as TripAgent",'photo','starnumber','profile_photo')
           ->with(['Services'=>function($query) use($lang){
          $query->select('serivces.id',"name->$lang as service_name",'photo')
                 ->where('status','active');
       }])->find($id);
       $HostName=request()->getHttpHost();
       $services=array();
       foreach($data->Services as $Service)
       {
         $array['tripagent_id']=$data->id;
            $array['tripagent_name']=$data->TripAgent;
            $array['tripagent_photo']="$HostName/assets/Profile/TripAgent/".$data->photo;
            $array['tripagentphoto_profile']="$HostName/assets/uploads/Profile/TripAgent/profile/".$data->profile_photo;
            $array['starnumber']=$data->starnumber;
            $array['service_id']=$Service->id;
             $array['service_name']=$Service->service_name;
             $array['photo']="$HostName/assets/uploads/Services/".$Service->photo;
            array_push($services,$array);
    }
        if($services)      
        {
         return $this->apiResponse($services,'ok',200);
        }
        else
        {
           return $this->apiResponse("",'No Data Found',404);
        }

    }

    public function getservice_attributes($id)
    {

      $data=Serivce::select('serivces.id','serivces.name')->with(['attributes'=>function($query){
         $query->select('attributes.id','attributes.name','attribute_types.name as attributetype_name','attr_typeid')
         ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
         ->orderby('id','asc');
      }])->find($id);
       if($data)
       {
         return $this->apiResponse($data,'ok',200);
       }
       else{
          return $this->apiResponse("",'No Data Found',404);
       }

    }

    public function showall_tourguides($lang)
    {
      if(TourGuide::get()->count()>0) 
      {
         $HostName=request()->getHttpHost();
         $data['TourGuides']=Tourguide::select('id',"name->$lang as TourGuide",'phone','photo','starnumber')
         ->where('verified_at',"!=",Null)
         ->orderby('id','desc')->paginate(10);
         $TourGuide=[];
         foreach($data['TourGuides'] as $data)
         {
            $array['id']=$data->id;
            $array['TourGuide']=$data->TourGuide;
            $array['phone']=$data->phone;
            $array['starnumber']=$data->starnumber;
            $array['photo']="$HostName/assets/uploads/Profile/TourGuide/Tripbackground/".$data->photo;
            array_push($TourGuide,$array);
         }
     return $this->apiResponse($TourGuide,'ok',200);

      }
      
        else
        {
           return $this->apiResponse("",'not data found',404);
        }

    }

  
    public function showtourguide_byid($lang,$id)
    {
     if(Tourguide::where('id',$id)->where('verified_at',"!=",Null)->exists())
     {
      $HostName=request()->getHttpHost();
      $data['TourGuide']=Tourguide::select('id',"name->$lang as TourGuide",'phone','photo','profile_photo',"desc->$lang as descrp",'starnumber')
       ->orderby('id','desc')
       ->where('id',$id)
       ->first();
    //  return response()->json($data['TourGuide']);
         $array['id']=$data['TourGuide']->id;
         $array['TourGuide']=$data['TourGuide']->TourGuide;
         $array['phone']=$data['TourGuide']->phone;
         $array['profile_photo']="$HostName/assets/uploads/Profile/TourGuide/".$data['TourGuide']->profile_photo;
         $array['background_photo']="$HostName/assets/uploads/Profile/TourGuide/Tripbackground/".$data['TourGuide']->photo;
         $array['desc']=$data['TourGuide']->descrp;
         $array['starnumber']=$data['TourGuide']->starnumber;
         return $this->apiResponse($array,'ok',200);
      
     
     }
     else
     {
      return $this->apiResponse("",'not data found',404);
     }

    }


    public function show_placesTovisits($lang)
    {
      $HostName=request()->getHttpHost();
      $data['PlacesToVisit']=PlacesToVisit::select('id',"name->$lang as Place_Name",'photo')
            ->paginate(10);
       $PlaceToVisit=[];
      foreach($data['PlacesToVisit'] as $data)
       {
          $array['id']=$data->id;
          $array['Place_name']=$data->Place_Name;
          $array['ImageURL']="$HostName/assets/uploads/PlacesToVisit/".$data->photo;
         array_push($PlaceToVisit,$array);
        }

      if($PlaceToVisit)
       {
         return $this->apiResponse($PlaceToVisit,'ok',200);

       }
       else
       {
        return $this->apiResponse("",'not data found',404);
       }
    }

    public function viewplacevisit_details($lang,$id)
    {
      $HostName=request()->getHttpHost();
      $data=PlacesToVisit::select('id',"name->$lang as Place_Name",'photo',"desc->$lang as descrption")
                           ->where('id',$id)
                           ->first();
      if($data !==Null)
       {
          $array['id']=$data->id;
          $array['Place_name']=$data->Place_Name;
          $array['ImageURL']="$HostName/assets/uploads/PlacesToVisit/".$data->photo;
          $array['desc']=$data->descrption;
          return $this->apiResponse($array,'ok',200);

         }
       else
       {
        return $this->apiResponse("",'not data found',404);
       }
    }

    public function allsearch($name)
    {
        $data[0]=Tourguide::select('name as TourGuide','desc')->where("tour_guides.name",'like','%'.$name.'%')->
                            orwhere("tour_guides.desc",'like','%'.$name.'%')->get();
        $data[1]=Tripagent::select('name as Tripagent','desc')->where("trip_agents.name",'like','%'.$name.'%')->
                           orwhere("trip_agents.desc",'like','%'.$name.'%')->get();
        $data[2]=Serivce::select('name as Serivcename','desc')->where("serivces.name",'like','%'.$name.'%')->
                           orwhere("serivces.desc",'like','%'.$name.'%')->get();
        if($data)
        {
           return $this->apiResponse($data,'ok',200);
        }
        else{
           return $this->apiResponse("",'not data found',404);
        }

    }

    public function showtermscondition($lang)
    {
      if(TermsandCondition::get()->count()>0)
      {
         $data=TermsandCondition::select('id',"desc->$lang as 'desc'")->get();
         return $this->apiResponse($data,'ok',200);

      }
      else
      {
         return $this->apiResponse('','No Data Found',404);
      }
    }

    public function showusageploicy($lang)
    {
      if(UsagePolicy::get()->count()>0)
      {
         $data=UsagePolicy::select('id',"desc->$lang as 'desc'")->get();
         return $this->apiResponse($data,'ok',200);

      }
      else
      {
         return $this->apiResponse('','No Data Found',404);
      }
    }

    public function showads_slideshow()
    {
      $url=request()->getHttpHost();
      $datas=AdsSlideShow::where('status','enabled')
                           ->orderby('id','desc')
                           ->take(4)
                           ->get();
       $AdsSlideshow=array();
       foreach($datas as $data)
       {
         $array['id']=$data->id;
         $array['photo']="$url/assets/uploads/AdsSlideShow/".$data->photo;
         $array['status']=$data->status;
         array_push($AdsSlideshow,$array);
       }
      
      if(count($AdsSlideshow)>0)
      {
         return $this->apiResponse($AdsSlideshow,'ok',200);
      }
      else{
         return $this->apiResponse('','No Data Found',404);

      }
    }

  public function getuser($userid)
  {
  
     if(User::where('id',$userid)->exists())
     {
      $url=request()->getHttpHost();
      $data=User::select('id','name','photo','phone')
                        ->where('id',$userid)
                     ->first();
    $userdata['user_id']=$data->id;
    $userdata['username']=$data->name;
    $userdata['phone']=$data->phone;
    $userdata['photo']="$url/public/assets/uploads/Profile/UserProfile/".$data->photo;
    return $this->apiResponse($userdata,'ok',200);

     }
     else{
      return $this->apiResponse('','No User Found',404);

     }
  }

  public function userprofile($userid)
  {
   if(User::where('id',$userid)->exists())
   {
    $url=request()->getHttpHost();
    $data=User::select('id','name','photo','phone')
                      ->where('id',$userid)
                   ->first();
                   
  $userdata['user_id']=$data->id;
  $userdata['username']=$data->name;
  $userdata['phone']=$data->phone;
  $userdata['photo']="$url/public/assets/uploads/Profile/UserProfile/".$data->photo;
  return $this->apiResponse($userdata,'ok',200);

   }
   else{
    return $this->apiResponse('','No User Found',404);

   }
  }
  
  public function shownotification($userid)
  {
   $today=Carbon::now();
   $oldnotification=UserNotification::where('user_id',$userid)
   ->where('expired_at','<=',$today)  
   ->delete();

   $user_notificaion=UserNotification::where('user_id',$userid)
    ->where('expired_at','>=',$today)  
    ->get();

     if($user_notificaion->count()>0)
     {
     return $this->apiResponse($user_notificaion,'ok',200);
   }
   else{
    return $this->apiResponse('','No User Found',404);

   }
  }
}
