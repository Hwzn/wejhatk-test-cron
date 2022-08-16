<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreferredMethodCommunication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class MethodCommunicationController extends Controller
{
    public function index()
    {
        $Preferred_Method=PreferredMethodCommunication::orderby('id','desc')->get();
        return view('dashboard.admin.Preferred_MethodCommunicat.index',compact('Preferred_Method'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'name_ar'=>'required|unique:preferredmethod_communications,name->ar',
             'name_en'=>'required|unique:preferredmethod_communications,name->en',
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $Preferred_MethodCommunicat=PreferredMethodCommunication::create([
              'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            ]);
            if(!is_null($Preferred_MethodCommunicat)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

    public function edit($id)
    {
        $Preferred_MethodCommunicat=PreferredMethodCommunication::findorfail($id);
      if($Preferred_MethodCommunicat)
      {
        return response()->json($Preferred_MethodCommunicat);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
            'name_ar'=>'required|unique:preferredmethod_communications,name->ar,'.$request->methodcommunicate_id,
             'name_en'=>'required|unique:preferredmethod_communications,name->en,'.$request->methodcommunicate_id,
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),    
        ]);

        
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
        }

        else{
            $Preferred_MethodCommunicat=PreferredMethodCommunication::where('id',$request->methodcommunicate_id)->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            ]);
         
            if(!is_null($Preferred_MethodCommunicat))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


    public function destroy($id)
    {
        $Preferred_MethodCommunicat=PreferredMethodCommunication::where('id',$id)->delete();
        if(!is_null($Preferred_MethodCommunicat))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}

