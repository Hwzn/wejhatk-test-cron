<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsagePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class UsagePolicyController extends Controller
{
    public function index()
    {
      $UsagePolices=UsagePolicy::orderby('id','desc')->first();
        return view('dashboard.admin.usagepolicys.index',compact('UsagePolices'));

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
          DB::table('usage_policies')->delete();
          $UsagePolices=UsagePolicy::create([
              'desc' => ['en' => $request->desc_en, 'ar' => $request->desc_ar],
            ]);
            if(!is_null($UsagePolices)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

}
