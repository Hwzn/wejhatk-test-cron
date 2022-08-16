<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\SendNotificationsTrait;

use App\Models\DeviceToken;
use App\Models\Tripagent;
use Illuminate\Http\Request;

class TripAgentController extends Controller
{
  use SendNotificationsTrait;

    public function index()
    {
        $data=Tripagent::orderby('id','desc')->get();
        return view('dashboard.admin.Activited_Accounts.tripagents.index',compact('data'));


    }

    public function edit($id)
    {
        $tripagent=Tripagent::findorfail($id);
        if($tripagent)
        {
          return response()->json($tripagent);
        }
    }

    public function update(Request $request)
    {
        // return response($request);
      $data=Tripagent::where('id',$request->tripagent_id)->first();
      if($data)
      {
        $data->update([
          'status'=>$request->status==1?'active':'not_active',

        ]);
      }
     

      $user_tokens=DeviceToken::where('tripagent_id',$request->tripagent_id)->pluck('token')->toarray();
      $noification_title="Activation Message";
      $notification_body='Your Account  has been '.$data->status;
  //  $notification_body=['en'=>'Your Account  has been '.$data->status,'ar'=>'لقد تم تغير حالة الحساب الي '.$data->status];
        $message_content='Your Account  has been '.$data->status;

      // return response()->json($notification_body);

    
      if(!is_null($data))
      {

        $this->sendnotification(null,$request->tripagent_id,null,$noification_title,$notification_body,$user_tokens,$message_content);


         toastr()->success(trans('messages_trans.success'));
         return response()->json(['success'=>"account has been $data->status"]);
      }
    
     
    
      
    }
}
