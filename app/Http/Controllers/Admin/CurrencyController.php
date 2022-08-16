<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class CurrencyController extends Controller
{
    public function index()
    {
        $currencies=Currency::orderby('id','asc')->get();
        return view('dashboard.admin.currencies.index',compact('currencies'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'name_ar'=>'required|unique:currencies,name->ar',
             'name_en'=>'required|unique:currencies,name->en',
             'name_ar.required'=>trans('validation.required'),
             'name_en.required'=>trans('validation.required'),

             'shortname_ar'=>'required|unique:currencies,short_name->ar',
             'shortname_en'=>'required|unique:currencies,short_name->en',
             'shortname_ar.required'=>trans('validation.required'),
             'shortname_en.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
            $currencies=Currency::create([
              'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
              'short_name' => ['en' => $request->shortname_en, 'ar' => $request->shortname_ar],
            ]);
            if(!is_null($currencies)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

    public function edit($id)
    {
        $currencies=Currency::findorfail($id);
      if($currencies)
      {
        return response()->json($currencies);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
            'name_ar'=>'required|unique:currencies,name->ar,'.$request->currency_id,
            'name_en'=>'required|unique:currencies,name->en,'.$request->currency_id,
            'name_ar.required'=>trans('validation.required'),
            'name_en.required'=>trans('validation.required'),

            'shortname_ar'=>'required|unique:currencies,short_name->ar,'.$request->currency_id,
            'shortname_en'=>'required|unique:currencies,short_name->en,'.$request->currency_id,
            'shortname_ar.required'=>trans('validation.required'),
            'shortname_en.required'=>trans('validation.required'),
        ]);

        
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
        }

        else{
          $currancy=[
            'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            'short_name' => ['en' => $request->shortname_en, 'ar' => $request->shortname_ar],
          ];
            $currencies=Currency::where('id',$request->currency_id)->update($currancy);
         
            if(!is_null($currencies))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


    public function destroy($id)
    {
        $currencies=Currency::where('id',$id)->delete();
        if(!is_null($currencies))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}

