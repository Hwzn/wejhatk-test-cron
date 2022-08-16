<?php

namespace App\Http\Controllers\Api\Tourguide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Serivce;
use App\Models\TourGuide;
use App\Models\Tripagent;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use App\Support\Collection;
use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\Traits\SendNotificationsTrait;
use App\Models\DeviceToken;
use Illuminate\Support\Facades\DB;


class MyreservationController extends Controller
{
    use ApiResponseTrait;
    use SendNotificationsTrait;

    public function myreservations($lang,$page)
    {
      $HostName=request()->getHttpHost();
      $Tourguide_id=Auth::user()->id;
      $lang=strtolower($lang);

       if(Booking::where('Tourguide_id',$Tourguide_id)->where('status','!=','refused')
         ->where('Package_id',Null)->exists())
       {
         $data['user_reservations']=Booking::where('Tourguide_id',$Tourguide_id)
                                            ->where('status','!=','refused')
                                            ->where('Package_id',Null)
                                            ->get();
       // return response()->json($data['user_reservations']);
        $booking=[];

           foreach($data['user_reservations'] as $data)
           {
            $users=User::where('id',$data->User_id)
            ->select("name as user_name",'photo as userphoto')
            ->first();
            $service=Serivce::where('id',$data->Service_id)
            ->select('id',"name->$lang as service_name")
            ->first();

              $booking[$data->id]['booking_id']='#'.$data->id;
              $booking[$data->id]['User_id']=$data->User_id;
              $booking[$data->id]['User_name']=$users->user_name;
              if($users->userphoto !==null)
              {
                   $booking[$data->id]['user_photo']="$HostName/public/assets/uploads/Profile/UserProfile/".$users->userphoto;
              }
             else
             {
                  $booking[$data->id]['user_photo']="$HostName/public/assets/uploads/Profile/UserProfile/defaultimage.jpg";
             }
              $booking[$data->id]['Service_id']=$data->Service_id;
              $booking[$data->id]['Service_Name']=$service->service_name;

             
             if($lang=='ar' && $data->status=='pending')
             {
               $booking[$data->id]['Status']='تحت المراجعة';
             }
             elseif($lang=='ar' && $data->status=='accepted')
             {
               $booking[$data->id]['Status']='تم الإستلام';
             }
             elseif($lang=='ar' && $data->status=='completed')
             {
               $booking[$data->id]['Status']='تم التأكيد';
             }
            
             else{
               $booking[$data->id]['Status']=$data->status;
             }
              $booking[$data->id]['Created_at']=$data->created_at;
              $booking[$data->id]['Updated_at']=$data->updated_at;

              
           }

          $results = (new Collection($booking))->paginate(10,0,$page);
          if(!empty($results->count()>0))  
          {
            return $this->apiResponse($results,'ok',200);
          }    
          else{
            return $this->apiResponse("",'Thepervious page  is Last Page',200);

          }  

       }
       else{
         return $this->apiResponse('','NoReservations Found',404);
      }
    }  
    
    
    public function change_reservationstatus($id,$status)
    {
       // enum('pending', 'accepted', 'completed', 'refused'... 
        $Tourguide_id=Auth::user()->id;
        if(Booking::where('Tourguide_id',$Tourguide_id)->where('id',$id)->exists())
      {
        $data['user_reservations']=Booking::where('Tourguide_id',$Tourguide_id)
                                           ->where('id',$id)
                                           ->first();
                                           try{
                                            DB::beginTransaction();
                                            $Booking_number='#'.$data['user_reservations']->id;
                                           $user_id=$data['user_reservations']->User_id;
                                           $data['user_reservations']->update([
                                               'status'=>$status,
                                           ]);
                                    
                                          //  if($status=='confirmed') $status_ar='تم تأكيد طلب';elseif($status=='refused')$status_ar='تم رفض الطلب';
                                          //                         else $status_ar='تحت المراجعة';
                                          //    //notficaions
                                             if($user_id !==Null)
                                             {
                                                //send notifucation for tripagent
                                                $tourguide_name=Auth::user()->name;
                                                $user_tokens=DeviceToken::where('user_id',$user_id)->pluck('token')->toarray();
                                                $noification_title="Reservation Status Changed";
                                                $notification_body="Status Changed to $status For Your Reservation number  $Booking_number " ;
                                    
                                                //  $notification_body=$tripagent_name .' '.' Send Booking Request  Number '.'#'.$booking->id ;
                                                // return response()->json($notification_body);
                                                $message_content="Status Changed to $status For Your Reservation number  $Booking_number ";
                                               $this->sendnotification($user_id,null,null,$noification_title,$notification_body,$user_tokens,$message_content);
                                                   //sendnotifaction for admin
                                                  
                                             }
                                             DB::commit();
                                             return $this->apiResponse('Status Change Successfult','ok',200);
                                    
                                           }
                                           catch(\Exception $ex){
                                               DB::rollBack();
                                               return response()->json([
                                                   'message' => $ex,
                                               ], 404);
                                           }
 
              ////                             
     


    }
}
}