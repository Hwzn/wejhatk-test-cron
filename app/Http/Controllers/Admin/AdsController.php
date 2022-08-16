<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ads;
use App\Models\Currency;

class AdsController extends Controller
{
  public function index()
  {
      $data['ads']=Ads::orderby('id','asc')->get();
      $data['currency']=Currency::orderby('id','asc')->get();
       return view('dashboard.admin.ads.index')->with($data);
  }

  public function store(Request $request)
  {
      $validator = Validator::make($request->all(),
      [
           'name_ar'=>'required',
           'name_en'=>'required',
           'desc_ar'=>'required',
           'desc_en'=>'required',
           'price'=>'required',
           'currency_id'=>'required|exists:currencies,id',

           'name_ar.required'=>trans('validation.required'),
           'name_en.required'=>trans('validation.required'),
           'desc_ar.required'=>trans('validation.required'),
           'desc_en.required'=>trans('validation.required'),
           'price.required'=>trans('validation.required'),
           'currency_id.required'=>trans('validation.required'),

      ]);

      if ($validator->fails())
      {
      return response()->json(['error'=>$validator->errors()->all()]);

      }

      else {
          $ads=array(
              'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
              'price'=>$request->price,
              'description'=>['ar'=>$request->desc_ar,'en'=>$request->desc_en],
              'description'=>['ar'=>$request->desc_ar,'en'=>$request->desc_en],
              'currency_id'=>$request->currency_id
          );
          $ads=Ads::create($ads);
          if(!is_null($ads)) {
            toastr()->success(trans('messages_trans.success'));
            return response()->json(['success'=>'Added new records.']);
          }

        }
  }

  public function edit($id)
  {
      $ads=Ads::findorfail($id);
    if($ads)
    {
      return response()->json($ads);
    }
  }

  public function update(Request $request)
  { 
    $validator = Validator::make($request->all(),
      [
        'name_ar'=>'required',
        'name_en'=>'required',
        'desc_ar'=>'required',
        'desc_en'=>'required',
        'price'=>'required',
        'currency_id'=>'required|exists:currencies,id',

        'name_ar.required'=>trans('validation.required'),
        'name_en.required'=>trans('validation.required'),
        'desc_ar.required'=>trans('validation.required'),
        'desc_en.required'=>trans('validation.required'),
        'price.required'=>trans('validation.required'),
        'currency_id.required'=>trans('validation.required'),
      ]);

      if ($validator->fails())
      {
      return response()->json(['error'=>$validator->errors()->all()]);

      }

      else{
          $ads=array(
            'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
            'price'=>$request->price,
            'description'=>['ar'=>$request->desc_ar,'en'=>$request->desc_en],
            'currency_id'=>$request->currency_id,
             'status'=>$request->status==1?'active':'notactive',
        );
        
          $ads=Ads::where('id',$request->ads_id)->update($ads);
          if(!is_null($ads))
          {
            toastr()->success(trans('messages_trans.success'));
            return response()->json(['success'=>'Added new records.']);
          }
        }
  }


  public function destroy($id)
  {
      $ads=Ads::where('id',$id)->delete();
      if(!is_null($ads))
    {
      toastr()->error(trans('Service_trans.Message_Delete'));
      return response()->json(['success'=>'deleted  success.']);
    }
  }
}
