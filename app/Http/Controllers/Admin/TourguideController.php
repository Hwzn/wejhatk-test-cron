<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Traits\SendNotificationsTrait;

use App\Models\DeviceToken;
use App\Models\TourGuide;
class TourguideController extends Controller
{
    use SendNotificationsTrait;

    public function index()
    {
        $data=TourGuide::orderby('id','desc')->get();
        return view('dashboard.admin.Activited_Accounts.tourguides.index',compact('data'));


    }

    public function edit($id)
    {
        $TourGuide=TourGuide::findorfail($id);
        if($TourGuide)
        {
          return response()->json($TourGuide);
        }
    }

    public function update(Request $request)
    {
        // return response($request);
      $data=TourGuide::where('id',$request->tourguide_id)->first();
      if($data)
      {
        $data->update([
          'status'=>$request->status==1?'active':'not_active',

        ]);
      }
     

      $user_tokens=DeviceToken::where('tourguide_id',$request->tourguide_id)->pluck('token')->toarray();
      $noification_title="Activation Message";
      $notification_body='Your Account  has been '.$data->status .'from admin';
  //  $notification_body=['en'=>'Your Account  has been '.$data->status,'ar'=>'لقد تم تغير حالة الحساب الي '.$data->status];
      $message_content='Your Account  has been '.$data->status .'from admin';

      // return response()->json($notification_body);

    
      if(!is_null($data))
      {

        $this->sendnotification(null,null,$request->tourguide_id,$noification_title,$notification_body,$user_tokens,$message_content);


         toastr()->success(trans('messages_trans.success'));
         return response()->json(['success'=>"account has been $data->status"]);
      }
    
     
    
      
    }
}
