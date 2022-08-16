<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//
class CountryController extends Controller
{
    public function index()
    {
        $data['Countrys']=Country::orderby('id','desc')->get();
        return view('dashboard.admin.Countrys.index')->with($data);
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),
       [
            'name_ar'=>'required|unique:countries,name->ar',
            'name_en'=>'required|unique:countries,name->en',
            'name_ar.required'=>trans('validation.required'),
            'name_en.required'=>trans('validation.required') ,

       ]);

       if ($validator->fails())
       {
       return response()->json(['error'=>$validator->errors()->all()]);

       }

       else {
           $Country=Country::create([
             'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
           ]);
           if(!is_null($Country)) {
             toastr()->success(trans('messages_trans.success'));
             return response()->json(['success'=>'Added new records.']);
           }
 
         }
    }

    public function edit($id)
    {
       $Country=Country::findorfail($id);
       if($Country)
       {
         return response()->json($Country);
       }
    }

    public function update(Request $request)
    {
        // return response($request);
      $validator=Validator::make($request->all(),[
        'name_ar'=>'required|unique:agency_types,name->ar,'.$request->country_id,
        'name_en'=>'required|unique:agency_types,name->en,'.$request->country_id,
        'name_ar.required'=>trans('validation.required'),
        'name_en.required'=>trans('validation.required') ,
    ]);
    if ($validator->fails())
    {
    return response()->json(['error'=>$validator->errors()->all()]);
    }
    else{
      $data=Country::where('id',$request->country_id)->update([
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
       $data=Country::where('id',$id)->delete();
       if(!is_null($data))
     {
       toastr()->error(trans('Countrys_trans.Message_Delete'));
       return response()->json(['success'=>'deleted  success.']);
     }
   }

}
