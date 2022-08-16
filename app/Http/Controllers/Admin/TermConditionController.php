<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TermsandCondition;
use Illuminate\Support\Facades\DB;
class TermConditionController extends Controller
{
    public function index()
    {
      $TermsandConditions=TermsandCondition::orderby('id','desc')->first();
        return view('dashboard.admin.terms_conditions.index',compact('TermsandConditions'));

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'desc_ar'=>'required',
             'desc_en'=>'required',
             'desc_ar.required'=>trans('validation.required'),
             'desc_en.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
          DB::table('terms_conditions')->delete();
          $TermsandConditions=TermsandCondition::create([
              'desc' => ['en' => $request->desc_en, 'ar' => $request->desc_ar],
            ]);
            if(!is_null($TermsandConditions)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
              //return redirect()->route('showservices');
            }
  
          }
    }

   
}
