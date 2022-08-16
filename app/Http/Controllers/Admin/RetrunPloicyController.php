<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RetrunPloicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class RetrunPloicyController extends Controller
{
    public function index()
    {
      $retrun_ploicies=RetrunPloicy::orderby('id','desc')->get();
        return view('dashboard.admin.RetrunPloicys.index',compact('retrun_ploicies'));

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
          $retrun_ploicies=RetrunPloicy::create([
              'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            ]);
            if(!is_null($retrun_ploicies)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
  
          }
    }

    public function edit($id)
    {
        $retrun_ploicies=RetrunPloicy::findorfail($id);
      if($retrun_ploicies)
      {
        return response()->json($retrun_ploicies);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
            'name_ar'=>'required|unique:retrun_ploicies,name->ar,'.$request->policy_id,
            'name_en'=>'required|unique:retrun_ploicies,name->en,'.$request->policy_id,
            'name_ar.required'=>trans('validation.required'),
            'name_en.required'=>trans('validation.required'),
        ]);

        
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);
        }

        else{
          $retrun_ploicies=[
            'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
          ];
            $retrun_ploicie=RetrunPloicy::where('id',$request->policy_id)->update($retrun_ploicies);
            if(!is_null($retrun_ploicie))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


    public function destroy($id)
    {
        $ploicy=RetrunPloicy::where('id',$id)->delete();
        if(!is_null($ploicy))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}
