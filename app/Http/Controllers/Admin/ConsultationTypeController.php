<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultationType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ConsultationTypeController extends Controller
{
    public function index()
    {
        $ConsultationTypes=ConsultationType::orderby('id','desc')->get();
        return view('dashboard.admin.ConsultationType.index',compact('ConsultationTypes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'name_ar1'=>'required|unique:consultation_types,name->ar',
             'name_en1'=>'required|unique:consultation_types,name->en',
             'name_ar1.required'=>trans('validation.required'),
             'name_en1.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $ConsultationType=ConsultationType::create([
              'name' => ['en' => $request->name_en1, 'ar' => $request->name_ar1],
              'type'=>$request->type,
            ]);
            if(!is_null($ConsultationType)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

    public function edit($id)
    {
        $ConsultationType=ConsultationType::findorfail($id);
      if($ConsultationType)
      {
        return response()->json($ConsultationType);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
            'name_ar'=>'required|unique:consultation_types,name->ar,'.$request->consultationtype_id,
             'name_en'=>'required|unique:consultation_types,name->en,'.$request->consultationtype_id,
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),    
        ]);

        
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
        }

        else{
            $ConsultationType=ConsultationType::where('id',$request->consultationtype_id)->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'type'=>$request->type,
                'status'=>$request->status==1?'active':'not_active',
            ]);
         
            if(!is_null($ConsultationType))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


    public function destroy($id)
    {
        $ConsultationType=ConsultationType::where('id',$id)->delete();
        if(!is_null($ConsultationType))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}

