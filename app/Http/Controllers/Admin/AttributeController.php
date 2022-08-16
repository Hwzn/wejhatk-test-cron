<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Attribute;
use App\Models\AttributeType;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function index()
    {
        $data['attruibtes']=Attribute::orderby('id','desc')->get();
        $data['attruib_type']=AttributeType::orderby('id','desc')->get();

        return view('dashboard.admin.attributes.index')->with($data);
    }

    public function store(Request $request)
    {
      
      $validator = Validator::make($request->all(),
        [
             'attribute_ar'=>'required|unique:serivces,name->ar',
             'attribute_en'=>'required|unique:serivces,name->en',
             'attribute_ar.required'=>trans('validation.required'),
             'attribute_en.required'=>trans('validation.required')         
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $attribute=Attribute::create([
              'name' => ['en' => $request->attribute_en, 'ar' => $request->attribute_ar],
              'attr_typeid'=>$request->attribute_type,
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
        $attribute=Attribute::where('id',$id)->delete();
        if(!is_null($attribute))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

    public function edit($id)
    {
      $attribute=Attribute::findorfail($id);
      if($attribute)
      {
        return response()->json($attribute);
      }
    }

    public function update(Request $request)
    {
         // return response($request);
         $validator=Validator::make($request->all(),[
          'attribute_ar'=>'required|unique:attributes,name->ar,'.$request->attribute_id,
          'attribute_en'=>'required|unique:attributes,name->en,'.$request->attribute_id,

      ]);
      if ($validator->fails())
      {
      return response()->json(['error'=>$validator->errors()->all()]);
      }
      
      else{
        $attribute=Attribute::where('id',$request->attribute_id)->update([
          'name' => ['en' => $request->attribute_en,'ar' => $request->attribute_ar],
          'attr_typeid'=>$request->attri_typeid,
        ]);
  
      
        if(!is_null($attribute))
        {
          toastr()->success(trans('messages_trans.success'));
          return response()->json(['success'=>'Added new records.']);
        }
      }
    }

}
