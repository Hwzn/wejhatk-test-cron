<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\AdsAttribute;
use App\Models\AttributeType;

class AdsController extends Controller
{
    public function adsattribute()
    {
        $data['adsattruibtes']=AdsAttribute::orderby('id','desc')->get();
        $data['attruib_type']=AttributeType::orderby('id','desc')->get();

        return view('dashboard.admin.attributes.ads.index')->with($data);
    }

    public function add_adsattribute(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'attribute_ar'=>'required|unique:ads_attributes,name->ar',
             'attribute_en'=>'required|unique:ads_attributes,name->en',
             'attribute_ar.required'=>trans('validation.required'),
             'attribute_en.required'=>trans('validation.required')         
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $attribute=AdsAttribute::create([
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

    public function edit_adsattrib($id)
    {
        $attribute=AdsAttribute::findorfail($id);
      if($attribute)
      {
        return response()->json($attribute);
      }
    }

public function update_adsattr(Request $request)
{
     // return response($request);
     $validator=Validator::make($request->all(),[
        'attribute_ar'=>'required|unique:ads_attributes,name->ar,'.$request->attribute_id,
        'attribute_en'=>'required|unique:ads_attributes,name->en,'.$request->attribute_id,

    ]);
    if ($validator->fails())
    {
    return response()->json(['error'=>$validator->errors()->all()]);
    }
    
    else{
      $attribute=AdsAttribute::where('id',$request->attribute_id)->update([
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

public function destroy($id)
{
    $attribute=AdsAttribute::where('id',$id)->delete();
    if(!is_null($attribute))
  {
    toastr()->error(trans('Service_trans.Message_Delete'));
    return response()->json(['success'=>'deleted  success.']);
  }
}

}
