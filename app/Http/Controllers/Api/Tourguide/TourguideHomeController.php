<?php

namespace App\Http\Controllers\Api\Tourguide;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\Booking;
use App\Models\StarRate;
use Illuminate\Support\Facades\Auth;
class TourguideHomeController extends Controller
{
  use ApiResponseTrait;
  public function index()
  {
     // countriesStatistic_AveragePakages
  $urlhost=request()->getHttpHost();
  $tour_guide=auth::user();
        $data['user_status']=Auth::user()->status;
  if($tour_guide->status=='active')
   {
    $data['tour_guide']['id']=$tour_guide->id;
    $data['tour_guide']['name']=$tour_guide->name;
    $data['tour_guide']['id']=$tour_guide->id;
    $data['tour_guide']['tripagent_id']=$tour_guide->tripagent_id;
    $data['tour_guide']['tripagent']=$tour_guide->trip_agent->name;
 
    if($tour_guide->profile_photo !==null)
    {
      $data['tour_guide']['profile_photo']="$urlhost/public/assets/uploads/Profile/TourGuide/".$tour_guide->profile_photo;
    }
    else
    {
      $data['tour_guide']['profile_photo']="$urlhost/public/assets/uploads/Profile/TourGuide/defaultimage.jpg";
    }

    if($tour_guide->photo !==null)
    {
      $data['tour_guide']['photo']="$urlhost/public/assets/uploads/Profile/TourGuide/Tripbackground/".$tour_guide->photo;
    }
    else
    {
      $data['tour_guide']['photo']="$urlhost/public/assets/uploads/Profile/TourGuide/Tripbackground/defaultimage.jpg";
    }
     


    $data['requests_counts']=Booking::where('Tourguide_id','!=',null)->count();
    $data['star_ratecount']=StarRate::where('to_tourguideid',$tour_guide->id)->count();
    $all_stars=StarRate::where('to_tourguideid',$tour_guide->id)->get();
     $data['star_rate']=array();
   
   //return response($all_stars);
    foreach($all_stars as $all_star)
    {
       $array['id']=$all_star->id;
       $array['user_id']=$all_star->from_userid;
       $photo=$all_star->user->photo;
       if($photo !==null)
       {
           $array['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/".$photo;
       }
       else
       {
           $array['photo']="$urlhost/public/assets/uploads/Profile/UserProfile/defaultimage.jpg";
       }
       $array['username']=$all_star->user->name;
       $array['star_rate']=$all_star->stars_rated;
       array_push($data['star_rate'],$array);
    }
  
    if($data)      
       {
        return $this->apiResponse($data,'ok',200);
       }
       else
       {
          return $this->apiResponse("",'No Data Found',404);
       }
   }
   else
   {
    return $this->apiResponse([],'user not activted from admin',404);
   }
  

  }
    public function shownotification()
    {
      $tour_guide=auth::user();
      if($tour_guide->status=='active')
      {
      $tourguide_id=auth()->user()->id;
      $today=Carbon::now();
      $oldnotification=UserNotification::where('tourguide_id',$tourguide_id)
      ->where('expired_at','<=',$today)  
      ->delete();
   
      $results=UserNotification::select('id','tourguide_id as userid','title',"body as message_content",'expired_at')
         ->where('tourguide_id',$tourguide_id)
          ->where('expired_at','>=',$today)  
        ->get();
   
        
        if(!empty($results))
        {
          return $this->apiResponse($results,'ok',200);
        }    
         else{
       return $this->apiResponse('','No notificaion found',404);
   
      }
    }
    else
    {
     return $this->apiResponse([],'user not activted from admin',404);
    }

    }
}
