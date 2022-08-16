<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreferredTimeCommunication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class TimeCommunicationController extends Controller
{
    public function index()
    {
        $Preferred_Time=PreferredTimeCommunication::orderby('id','desc')->get();
        return view('dashboard.admin.Preferred_TimeCommunicat.index',compact('Preferred_Time'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'name'=>'required|unique:preferred_timecommunications,name',
             'name.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $Preferred_TimeCommunicat=PreferredTimeCommunication::create([
              'name' => $request->name,
            ]);
            if(!is_null($Preferred_TimeCommunicat)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

    public function edit($id)
    {
        $Preferred_TimeCommunicat=PreferredTimeCommunication::findorfail($id);
      if($Preferred_TimeCommunicat)
      {
        return response()->json($Preferred_TimeCommunicat);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
            'name'=>'required|unique:preferred_timecommunications,name,'.$request->timecommunicate_id,
             'name.required'=>trans('validation.required'),
        ]);

        
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
        }

        else{
            $Preferred_TimeCommunicat=PreferredTimeCommunication::where('id',$request->timecommunicate_id)->update([
                'name' =>$request->name,
            ]);
         
            if(!is_null($Preferred_TimeCommunicat))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


    public function destroy($id)
    {
        $Preferred_TimeCommunicat=PreferredTimeCommunication::where('id',$id)->delete();
        if(!is_null($Preferred_TimeCommunicat))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}

