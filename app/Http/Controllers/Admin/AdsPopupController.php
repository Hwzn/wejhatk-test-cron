<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdsSocialMedia;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\Traits\SendNotificationsTrait;
use App\Models\AdsRequests;

class AdsPopupController extends Controller
{
    use SendNotificationsTrait;

    public function index()
    {
        $ads=AdsRequests::where('adstype_id',2)->orderby('id','desc')->get();
        return view('dashboard.admin.ads.popupads.requests',compact('ads'));
 
    }
    public function view_popattachment($filename)
    {
      return response()->download('assets/uploads/Ads/Popup_Ads/'.$filename);
 
    }
 
    public function showrequestad_details($id)
    {
        $ad=AdsRequests::where('id',$id)->first();
        return response($ad);
    }
    public function update(Request $request)
    {
         // return response()->json($request);
         $validator = Validator::make($request->all(),
         [
             'admin_reply'=>'required',
             'admin_reply.required'=>trans('validation.required'),
             'actual_price'=>'required',
             'actual_price.required'=>trans('validation.required'),
             'ads_id'=>'required|exists:ads_requests,id',
             'ads_id.required'=>trans('validation.required'),
 
         ]);
 
         if ($validator->fails())
         {
         return response()->json(['error'=>$validator->errors()->all()]);
 
         }
         else
         {
         
         $data=AdsRequests::where('id',$request->ads_id)->update([
             'admin_desc'=>$request->admin_reply,
             'actual_price'=>$request->actual_price,
             'status'=>$request->status,
         ]);
 
         //send notfication for user
         
         
             if($request->status=='confirmed')
             {
                 $message_content="Your Request Number # $request->ads_id has been Confirmed Now You can pay your ads with price $request->actual_price";
                 $noification_title="Your Ads_request Confirmed";
                 $notification_body="Your Request Number # $request->ads_id has been Confirmed Now You can pay your ads with price $request->actual_price";
             }
             if($request->status=='refused')
             {
                 $message_content="Your Request Number # $request->ads_id has been refused : $request->admin_reply";
                 $noification_title="Your Ads_request Refused";
                 $notification_body="Your Request Number # $request->ads_id has been refused : $request->admin_reply";
             }
             if(!is_null($request->tripagent_id))
             {
                 $user_tokens=DeviceToken::where('tripagent_id',$request->tripagent_id)->pluck('token')->toarray();
                 $this->sendnotification(null,$request->tripagent_id,null,$noification_title,$notification_body,$user_tokens,$message_content);
     
             }
         
         
             //  $this->store_notification($request->user_id,$noification_title,$notification_body);
             toastr()->success(trans('messages_trans.success'));
             return response()->json(['success'=>'Added new records.']);
 
 
          }
         }
}
