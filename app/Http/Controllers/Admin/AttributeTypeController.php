<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AttributeType;
use Illuminate\Support\Facades\Validator;

class AttributeTypeController extends Controller
{
    public function index()
    {
        $data['attribute_types']=AttributeType::orderby('id','desc')->get();
        return view('dashboard.admin.attributetype.index')->with($data);

    }
    
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
             'attribute_typeName'=>'required|unique:attribute_types,name',
             'attribute_typeName.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $attribute=AttributeType::create([
              'name' =>$request->attribute_typeName,
            ]);
            if(!is_null($attribute)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
              //return redirect()->route('showservices');
            }
  
          }
    }

    public function destroy($id)
    {
        $attribute=AttributeType::where('id',$id)->delete();
        if(!is_null($attribute))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

    public function edit($id)
    {
        $attribute=AttributeType::findorfail($id);
        if(!is_null($attribute))
        {
            return response()->json($attribute);
        }
    }

    public function update(Request $request)
    {
        // return response($request);
      $validator=Validator::make($request->all(),[
        // 'service_ar'=>'required|unique:serivces,name,'.$request->service_id,
        'Name'=>'required|unique:attribute_types,name,'.$request->attributetype_id,
        
    ]);
    if ($validator->fails())
    {
    return response()->json(['error'=>$validator->errors()->all()]);
    }
    
    else{
      $attribute=AttributeType::where('id',$request->attributetype_id)->update([
        'name' => $request->Name,
      ]);

    
      if(!is_null($attribute))
      {
        toastr()->success(trans('messages_trans.success'));
        return response()->json(['success'=>'Added new records.']);
      }
    }
      
    }
}
