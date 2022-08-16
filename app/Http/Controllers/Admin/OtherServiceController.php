<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class OtherServiceController extends Controller
{
    public function index()
    {
        $OtherServices=OtherService::orderby('id','desc')->get();
        return view('dashboard.admin.OtherService.index',compact('OtherServices'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'name_ar'=>'required|unique:other_services,name->ar',
             'name_en'=>'required|unique:other_services,name->en',
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $OtherService=OtherService::create([
              'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            ]);
            if(!is_null($OtherService)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

    public function edit($id)
    {
        $OtherService=OtherService::findorfail($id);
      if($OtherService)
      {
        return response()->json($OtherService);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
            'name_ar'=>'required|unique:other_services,name->ar,'.$request->OtherService_id,
             'name_en'=>'required|unique:other_services,name->en,'.$request->OtherService_id,
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),    
        ]);

        
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
        }

        else{
            $OtherService=OtherService::where('id',$request->OtherService_id)->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            ]);
         
            if(!is_null($OtherService))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


    public function destroy($id)
    {
        $OtherService=OtherService::where('id',$id)->delete();
        if(!is_null($OtherService))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}

