<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class CarTypeController extends Controller
{
    public function index()
    {
        $car_types=CarType::orderby('id','desc')->get();
        return view('dashboard.admin.car_type.index',compact('car_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'name_ar'=>'required|unique:car_types,name->ar',
             'name_en'=>'required|unique:car_types,name->en',
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $car_type=CarType::create([
              'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            ]);
            if(!is_null($car_type)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

    public function edit($id)
    {
        $car_type=CarType::findorfail($id);
      if($car_type)
      {
        return response()->json($car_type);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
            'name_ar'=>'required|unique:car_types,name->ar,'.$request->cartype_id,
             'name_en'=>'required|unique:car_types,name->en,'.$request->cartype_id,
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),    
        ]);

        
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
        }

        else{
            $car_type=CarType::where('id',$request->cartype_id)->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'status'=>$request->status==1?'enabled':'disabled',
            ]);
         
            if(!is_null($car_type))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


    public function destroy($id)
    {
        $car_type=CarType::where('id',$id)->delete();
        if(!is_null($car_type))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}

