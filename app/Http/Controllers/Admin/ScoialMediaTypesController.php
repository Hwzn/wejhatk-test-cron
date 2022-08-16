<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScoialMediaTypesController extends Controller
{
    public function index()
    {
        $data['SocialMediaTypes']=SocialMediaTypes::orderby('id','asc')->get();
         return view('dashboard.admin.ads.social_mediatypes.index')->with($data);
    }
  
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'name_ar'=>'required',
             'name_en'=>'required',
           
  
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),
         
  
        ]);
  
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
  
        }
  
        else {
            $SocialMediaTypes=array(
                'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
            );
            $ads=SocialMediaTypes::create($SocialMediaTypes);
            if(!is_null($SocialMediaTypes)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }
  
    public function edit($id)
    {
        $SocialMediaTypes=SocialMediaTypes::findorfail($id);
      if($SocialMediaTypes)
      {
        return response()->json($SocialMediaTypes);
      }
    }
  
    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
          'name_ar'=>'required',
          'name_en'=>'required',
         
  
          'name_ar.required'=>trans('validation.required'),
          'name_en.required'=>trans('validation.required'),
         
        ]);
  
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
  
        }
  
        else{
            $ads=array(
              'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
               'status'=>$request->status==1?'active':'notactive',
          );
          
            $ads=SocialMediaTypes::where('id',$request->ads_id)->update($ads);
            if(!is_null($ads))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }
  
  
    public function destroy($id)
    {
        $ads=SocialMediaTypes::where('id',$id)->delete();
        if(!is_null($ads))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }
}
