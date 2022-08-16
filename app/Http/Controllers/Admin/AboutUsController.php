<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class AboutUsController extends Controller
{
    public function index()
    {
        $aboutus=AboutUs::first();
        return view('dashboard.admin.aboutus.index',compact('aboutus'));
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(),
        [
             'desc_ar'=>'required',
             'desc_en'=>'required',
             'desc_ar.required'=>trans('validation.required'),
             'desc_en.required'=>trans('validation.required')         
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
           DB::table('about_us')->delete();
          $aboutus=AboutUs::create([
              'desc' => ['en' => $request->desc_en, 'ar' => $request->desc_ar],
            ]);
            if(!is_null($aboutus)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

  


}
