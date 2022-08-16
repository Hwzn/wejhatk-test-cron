<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgencyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AgencyTypeController extends Controller
{
    public function index()
    {
        $data['AgencyTypes']=AgencyType::orderby('id','desc')->get();
        return view('dashboard.admin.AgencyTypes.index')->with($data);
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),
       [
            'name_ar'=>'required|unique:agency_types,name->ar',
            'name_en'=>'required|unique:agency_types,name->en',
            'name_ar.required'=>trans('validation.required'),
            'name_en.required'=>trans('validation.required') ,

       ]);

       if ($validator->fails())
       {
       return response()->json(['error'=>$validator->errors()->all()]);

       }

       else {
           $AgencyType=AgencyType::create([
             'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
           ]);
           if(!is_null($AgencyType)) {
             toastr()->success(trans('messages_trans.success'));
             return response()->json(['success'=>'Added new records.']);
           }
 
         }
    }

    public function edit($id)
    {
       $AgencyType=AgencyType::findorfail($id);
       if($AgencyType)
       {
         return response()->json($AgencyType);
       }
    }

    public function update(Request $request)
    {
        // return response($request);
      $validator=Validator::make($request->all(),[
        'name_ar'=>'required|unique:agency_types,name->ar,'.$request->agency_typeid,
        'name_en'=>'required|unique:agency_types,name->en,'.$request->agency_typeid,
        'name_ar.required'=>trans('validation.required'),
        'name_en.required'=>trans('validation.required') ,
    ]);
    if ($validator->fails())
    {
    return response()->json(['error'=>$validator->errors()->all()]);
    }
    else{
      $data=AgencyType::where('id',$request->agency_typeid)->update([
        'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
        'status'=>$request->status==1?'Active':'Not_active',
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
       $data=AgencyType::where('id',$id)->delete();
       if(!is_null($data))
     {
       toastr()->error(trans('AgencyTypes_trans.Message_Delete'));
       return response()->json(['success'=>'deleted  success.']);
     }
   }

}
