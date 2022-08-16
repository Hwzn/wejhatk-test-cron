<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\RetrunPloicy;
class PackageController extends Controller
{
    public function index()
    {
        $data['Packages']=Package::orderby('id','asc')->get();
        $data['currencies']=Currency::orderby('id','asc')->get();
        $data['return_policiy']=RetrunPloicy::orderby('id','asc')->get();

         return view('dashboard.admin.packages.index')->with($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
             'destnation_ar'=>'required|',
             'destnation_en'=>'required|',

             'currency_id'=>'required|exists:currencies,id',
             'price'=>'required',
             'person_num_ar'=>'required',
             'person_num_en'=>'required',

             'days'=>'required',

             'person_num_ar.required'=>trans('validation.required'),
             'person_num_en.required'=>trans('validation.required'),
             'destination_ar.required'=>trans('validation.required'),
             'destination_en.required'=>trans('validation.required'),
             'currency_id.required'=>trans('validation.required'),
             'price.required'=>trans('validation.required'),
             'person_num_ar.required'=>trans('validation.required'),
             'person_num_en.required'=>trans('validation.required'),

             
             'days.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else {
         // $packagedesc=['ar'=>$request->packagedesc_ar,'en'=>$request->packagedesc_en];
            $packages=array(
                'destination'=>['ar'=>$request->destnation_ar,'en'=>$request->destnation_en],
                'currency_id'=>$request->currency_id,
                'price'=>$request->price,
                'person_num'=>['ar'=>$request->person_num_ar,'en'=>$request->person_num_en],
                'days'=>$request->days,
                'package_desc'=>['ar'=>$request->packagedesc_ar,'en'=>$request->packagedesc_en],
                'package_contain'=>['ar'=>$request->packagecontain_ar,'en'=>$request->packagecontain_ar],
                'conditions'=>['ar'=>$request->conditions_ar,'en'=>$request->conditions_en],
                'cancel_conditions'=>['ar'=>$request->cancelconditions_ar,'en'=>$request->cancelconditions_en],
                'package_notinclude'=>['ar'=>$request->notinclude_ar,'en'=>$request->notinclude_en],
                'ReturnPloicy_id'=>$request->policy_id,

                
            );




            $package=Package::create($packages);
            if(!is_null($package)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }

  
          }
    }

    public function edit($id)
    {
        $Packages=Package::findorfail($id);
      if($Packages)
      {
        return response()->json($Packages);
      }
    }

    public function update(Request $request)
    { 
      $validator = Validator::make($request->all(),
        [
             'destnation_ar'=>'required|',
             'destnation_en'=>'required|',

             'currency_id'=>'required|exists:currencies,id',
             'price'=>'required',
             'person_num_ar'=>'required',
             'person_num_en'=>'required',

             'days'=>'required',

             'person_num_ar.required'=>trans('validation.required'),
             'person_num_en.required'=>trans('validation.required'),
             'destination_ar.required'=>trans('validation.required'),
             'destination_en.required'=>trans('validation.required'),
             'currency_id.required'=>trans('validation.required'),
             'price.required'=>trans('validation.required'),
             'person_num_ar.required'=>trans('validation.required'),
             'person_num_en.required'=>trans('validation.required'),

             'days.required'=>trans('validation.required'),
        ]);

        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }

        else{
          
          $pakcage=[
            'destination'=>['ar'=>$request->destnation_ar,'en'=>$request->destnation_en],
            'currency_id'=>$request->currency_id,
            'price'=>$request->price,
            'person_num'=>['ar'=>$request->person_num_ar,'en'=>$request->person_num_en],
            'days'=>$request->days,
            'package_desc'=>['ar'=>$request->packagedesc_ar,'en'=>$request->packagedesc_en],
            'package_contain'=>['ar'=>$request->packagecontain_ar,'en'=>$request->packagecontain_ar],
            'conditions'=>['ar'=>$request->conditions_ar,'en'=>$request->conditions_en],
            'cancel_conditions'=>['ar'=>$request->cancelconditions_ar,'en'=>$request->cancelconditions_en],
            'package_notinclude'=>['ar'=>$request->notinclude_ar,'en'=>$request->notinclude_en],
            'ReturnPloicy_id'=>$request->policy_id,

            
            'status'=>$request->status==1?'active':'notactive',
          ];
          
            $Packages=Package::where('id',$request->package_id)->update($pakcage);
         
            if(!is_null($Packages))
            {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
            }
          }
    }


    public function destroy($id)
    {
        $Packages=Package::where('id',$id)->delete();
        if(!is_null($Packages))
      {
        toastr()->error(trans('Service_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}

