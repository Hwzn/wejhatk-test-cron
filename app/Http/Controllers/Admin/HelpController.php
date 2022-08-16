<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Help;
use App\Models\HelpRequest;
use App\Http\Controllers\Admin\Traits\SendNotificationsTrait;
use App\Models\DeviceToken;

class HelpController extends Controller
{
  use SendNotificationsTrait;

  public function index()
     {
         $data['helps']=Help::orderby('id','desc')->get();
         return view('dashboard.admin.helps.index')->with($data);
     }

     public function store(Request $request)
     {
        $validator = Validator::make($request->all(),
        [
             'name_ar'=>'required',
             'name_en'=>'required',
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required')         
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $aboutus=Help::create([
              'name'=>['en'=>$request->name_en,'ar'=>$request->name_ar],
            ]);
            if(!is_null($aboutus)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
     }

     public function edit($id)
     {
        $help_data=Help::findorfail($id);
        if($help_data)
        {
          return response()->json($help_data);
        }
     }

     public function update(Request $request)
     {
         // return response($request);
       $validator=Validator::make($request->all(),[
              'name_ar'=>'required|unique:helps,name->ar,'.$request->help_id,
              'name_en'=>'required|unique:helps,name->en,'.$request->help_id,
              'name_ar.required'=>trans('validation.required'),
              'name_en.required'=>trans('validation.required')    
     ]);
     if ($validator->fails())
     {
     return response()->json(['error'=>$validator->errors()->all()]);
     }
     
     else{
       $data=Help::where('id',$request->help_id)->update([
         'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
       ]);
 
     
       if(!is_null($data))
       {
         toastr()->success(trans('messages_trans.success'));
         return response()->json(['success'=>'Added new records.']);
       }
     }
       
     }

     public function destroy($id)
    {
        $data=Help::where('id',$id)->delete();
        if(!is_null($data))
      {
        toastr()->error(trans('helps_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

    public function helpRequests()
    {
      $requests=HelpRequest::orderby('id','desc')->paginate(10);
     // return $requests;
      return view('dashboard.admin.helps.help_requests.requestshelp',compact('requests'));
    }

    public function view_attachment($filename)
    {
      return response()->download('assets/uploads/HelpRequests/UsersHelpRequest/'.$filename);

    }
    public function viewtripagent_attachment($filename)
    {
      return response()->download('assets/uploads/HelpRequests/TripagentsHelpRequest/'.$filename);

    }

    public function viewtourguide_attachment($filename)
    {
      return response()->download('assets/uploads/HelpRequests/TourguidesHelpRequest/'.$filename);

    }
    

    
    public function showrequestdetials($id)
    {
      $request_details=HelpRequest::findorfail($id);
      return response()->json($request_details);
    }
 
    public function updaterequesthelp_details(Request $request)
    {
     // return response()->json($request);
      $validator = Validator::make($request->all(),
      [
           'admin_reply'=>'required',
           'admin_reply.required'=>trans('validation.required'),
           'request_id'=>'required|exists:help_requests,id',
           'request_id.required'=>trans('validation.required'),

      ]);

      if ($validator->fails())
      {
      return response()->json(['error'=>$validator->errors()->all()]);

      }
      else
      {
        
        $data=HelpRequest::where('id',$request->request_id)->update([
          'admin_reply'=>$request->admin_reply,
          'status'=>'closed'
        ]);

        //send notfication for user
        $message_content="Your Request Number $request->ticket_num has been update From Admin";
        if(!is_null($request->user_id))
        {
          $user_tokens=DeviceToken::where('user_id',$request->user_id)->pluck('token')->toarray();
          $noification_title="Update Hlep Request";
          $notification_body='Your Request Number '.'#'.$request->ticket_num .' has been update2022';
          $this->sendnotification($request->user_id,null,null,$noification_title,$notification_body,$user_tokens,$message_content);
        }
        elseif(!is_null($request->tripagent_id))
        {
          $user_tokens=DeviceToken::where('tripagent_id',$request->tripagent_id)->pluck('token')->toarray();
          $noification_title="Update Hlep Request";
          $notification_body='Your Request Number '.'#'.$request->ticket_num .' has been update From Admin';
          $this->sendnotification(null,$request->tripagent_id,null,$noification_title,$notification_body,$user_tokens,$message_content);

        }

        elseif(!is_null($request->tourguide_id))
        {
          $user_tokens=DeviceToken::where('tourguide_id',$request->tourguide_id)->pluck('token')->toarray();
          $noification_title="Update Hlep Request";
          $notification_body='Your Request Number '.'#'.$request->ticket_num .' has been update From Admin';
          $this->sendnotification(null,null,$request->tourguide_id,$noification_title,$notification_body,$user_tokens,$message_content);

        }
       
          //  $this->store_notification($request->user_id,$noification_title,$notification_body);
           toastr()->success(trans('messages_trans.success'));
           return response()->json(['success'=>'Added new records.']);


      }
    }
}
