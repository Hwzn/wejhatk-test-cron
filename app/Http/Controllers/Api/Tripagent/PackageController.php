<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\Country;
use App\Models\CountryStatistics;
use App\Models\TripagentPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Booking;

class PackageController extends Controller
{
    use ApiResponseTrait;

    public function package_form()
    {
        $currencies=Currency::select('id',"short_name")->get()->toarray();

      //  return response()->json(gettype($currencies));
       $array=[];
        foreach($currencies as $curn)
        {
           $array['currencies'][$curn['id']]=$curn['short_name']['en'].'/'.$curn['short_name']['ar'];

        }
        $countries=Country::select('id',"name")->where('status','Active')->get()->toarray();
        foreach($countries as $country)
        {
           $array['countries'][$country['id']]=$country['name']['en'].'/'.$country['name']['ar'];

        }
        if($array)
          {
            return $this->apiResponse($array,'ok',200);
           }
           else
           {
              return $this->apiResponse("",'No Data Found',404);
           }
    }
    public function addpackage(Request $request)
    {
        $rules = 
        [
             'country_id'=>'required|exists:countries,id',
             'currency_id'=>'required|exists:currencies,id',
             'price'=>'required',
             'person_num'=>'required',
             'days'=>'required',
             'package_desc_ar'=>'required',
             'package_desc_en'=>'required',
             'conditions_ar'=>'required',
             'conditions_en'=>'required',
            'cancel_conditions_ar'=>'required',
            'cancel_conditions_en'=>'required',
            'package_contain_ar'=>'required',
            'package_contain_en'=>'required',
            'package_notinclude_ar'=>'required',
            'package_notinclude_en'=>'required',
            'ReturnPloicy_ar'=>'required',
            'ReturnPloicy_en'=>'required',
            'photo'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',

             'country_id.required'=>trans('validation.required'),
             'currency_id.required'=>trans('validation.required'),
             'price.required'=>trans('validation.required'),
             'person_num.required'=>trans('validation.required'),
             'days.required'=>trans('validation.required'),
             'package_desc_en.required'=>trans('validation.required'),
             'package_desc_ar.required'=>trans('validation.required'),
             'conditions_ar.required'=>trans('validation.required'),
             'conditions_en.required'=>trans('validation.required'),

             'cancel_conditions_ar.required'=>trans('validation.required'),
             'cancel_conditions_en.required'=>trans('validation.required'),

             'package_contain_ar.required'=>trans('validation.required'),
             'package_contain_en.required'=>trans('validation.required'),
             'package_notinclude_ar.required'=>trans('validation.required'),
             'package_notinclude_en.required'=>trans('validation.required'),
             'ReturnPloicy_ar.required'=>trans('validation.required'),
             'ReturnPloicy_en.required'=>trans('validation.required'),

        ];
       
        $validator=Validator::make($request->all(),$rules);
              if($validator->fails())
              {
                  return response()->json($validator->errors(), 422);
              }

        else 
        {
          try
        {
          
          DB::beginTransaction();
          $helpimage=null;
          $rand_num=mt_rand(100000000,999999999); 
             if($request->hasfile('photo')) 
             {
                  $file=$request->file('photo');
                  $ext=$file->getClientOriginalExtension();
                  $filename=$rand_num.'.'.$ext;
                  $file->move('assets/uploads/Packages',$filename);
                  $helpimage=$filename;

             }
             $packages=array(
              'tripagent_id'=>Auth::user()->id,
              'country_id'=>$request->country_id,
              'currency_id'=>$request->currency_id,
              'price'=>$request->price,
              'person_num'=>$request->person_num,
              'days'=>$request->days,
              'package_desc'=>['ar'=>$request->package_desc_ar,'en'=>$request->package_desc_en],
              'conditions'=>['ar'=>$request->conditions_ar,'en'=>$request->conditions_en],
              'cancel_conditions'=>['ar'=>$request->cancel_conditions_ar,'en'=>$request->cancel_conditions_en],
              'package_contain'=>['ar'=>$request->package_contain_ar,'en'=>$request->package_contain_en],
              'package_notinclude'=>['ar'=>$request->package_notinclude_ar,'en'=>$request->package_notinclude_en],
              'ReturnPloicy'=>['ar'=>$request->ReturnPloicy_ar,'en'=>$request->ReturnPloicy_en],
              'photo'=>$helpimage,
            );

          $package=Package::create($packages);
          $current_packageid=Package::where('tripagent_id',Auth::user()->id)->latest()
             ->first()->id;
           //  return response()->json($current_packageid);
             $tropagent_package=TripagentPackage::create([
               'tripagent_id'=>Auth::user()->id,
               'package_id'=>$current_packageid,
             ]);
          //Auth::user()->id,
          $total_packagesprice=Package::where('country_id',$request->country_id)
                   ->where('status','active')
                   ->whereMonth('created_at',date('m'))
                   ->whereYear('created_at',date('Y'))
                   ->get()
                   ->sum('price');
          $total_packagescount=Package::where('country_id',$request->country_id)
                   ->where('status','active')
                   ->whereMonth('created_at',date('m'))
                   ->whereYear('created_at',date('Y'))
                   ->get()->count();
             //    return response()->json($total_packagesprice);
          $package_countryaverage=intval($total_packagesprice/$total_packagescount);
         // return response()->json($package_countryaverage);
          //add result package_countryaverage in countrystatics
          if(CountryStatistics::where('country_id',$request->country_id)
         ->whereMonth('created_at',date('m'))
         ->whereYear('created_at',date('Y'))->exists())
         {
            $country_statiistics=CountryStatistics::where('country_id',$request->country_id)
            ->whereMonth('created_at',date('m'))
            ->whereYear('created_at',date('Y'))->first();
            $country_statiistics->update([
               'averagepackage_price'=>$package_countryaverage,
            ]);
         }
         else
         {
            $country_statiistics=['country_id'=>$request->country_id,'requests_number'=>null,'averagepackage_price'=>$package_countryaverage];
            CountryStatistics::create($country_statiistics);

         }
        //add result package_countryaverage in countrystatics
          DB::commit();

          if(!is_null($package)) {
            return $this->apiResponse($package,'ok',200);
          }
          else
          {
            return $this->apiResponse('','Error in save Data',404);
           }

        }
          catch(\Exception $ex){
            DB::rollBack();
            return response()->json([
                'message' => $ex,
                'user' => 'd'
            ], 404);
        }
         // $packagedesc=['ar'=>$request->packagedesc_ar,'en'=>$request->packagedesc_en];
           

  
          }
    }

    public function change_status(Request $request)
    {
      $rules=[
        "package_id"=>'required|exists:packages,id',
        "status"=>'required'
    ];
      $validator=Validator::make($request->all(),$rules);
      if($validator->fails())
      {
          return response()->json($validator->errors(), 422);
      }
     $request_status=$request->status==1?'active':'notactive';

      $tripagent_id=Auth::user()->id;

      if((Package::where('id',$request->package_id)->where('tripagent_id',$tripagent_id))->exists())
      {
        Package::where('id',$request->package_id)->where('tripagent_id',$tripagent_id)
              ->update([
                 'status'=>$request_status,
              ]);
             
                  return $this->apiResponse("",'Status Updated',200);
              
      }
      else
      {
        return $this->apiResponse("Error",'Package not found for this user',404);

      }
    }

    public function edit($id)
    {
      $tripagent_id=Auth::user()->id;
      $package=Package::where('id',$id)->where('tripagent_id',$tripagent_id)->first();
      if(!is_null($package))
      {
        return $this->apiResponse($package,'ok',200);

      }
      else
      {
        return $this->apiResponse("Error",'Package not found for this user',404);

      }
    }

    public function update(Request $request,$id)
    {
    //  return response()->json($id);
      $rules = 
        [
             'destnation_ar'=>'required|',
             'destnation_en'=>'required|',
             'currency_id'=>'required|exists:currencies,id',
             'price'=>'required',
             'person_num'=>'required',
             'days'=>'required',
             'package_desc_ar'=>'required',
             'package_desc_en'=>'required',
             'conditions_ar'=>'required',
             'conditions_en'=>'required',
            'cancel_conditions_ar'=>'required',
            'cancel_conditions_en'=>'required',
            'package_contain_ar'=>'required',
            'package_contain_en'=>'required',
            'package_notinclude_ar'=>'required',
            'package_notinclude_en'=>'required',
            'ReturnPloicy_ar'=>'required',
            'ReturnPloicy_en'=>'required',
            'photo'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',

             'destination_ar.required'=>trans('validation.required'),
             'destination_en.required'=>trans('validation.required'),
             'currency_id.required'=>trans('validation.required'),
             'price.required'=>trans('validation.required'),
             'person_num.required'=>trans('validation.required'),
             'days.required'=>trans('validation.required'),
             'package_desc_en.required'=>trans('validation.required'),
             'package_desc_ar.required'=>trans('validation.required'),
             'conditions_ar.required'=>trans('validation.required'),
             'conditions_en.required'=>trans('validation.required'),

             'cancel_conditions_ar.required'=>trans('validation.required'),
             'cancel_conditions_en.required'=>trans('validation.required'),

             'package_contain_ar.required'=>trans('validation.required'),
             'package_contain_en.required'=>trans('validation.required'),
             'package_notinclude_ar.required'=>trans('validation.required'),
             'package_notinclude_en.required'=>trans('validation.required'),
             'ReturnPloicy_ar.required'=>trans('validation.required'),
             'ReturnPloicy_en.required'=>trans('validation.required'),

        ];
       
        $validator=Validator::make($request->all(),$rules);
              if($validator->fails())
              {
                  return response()->json($validator->errors(), 422);
              }

        else 
        {
          try
        {
           // $image=$user->photo;
         $user_id=Auth::user()->id;
         $photo=Package::where('id',$id)->where('tripagent_id',$user_id)->pluck('photo');
         $image=$photo[0];
         if($request->hasfile('photo')) 
        {
            //هشيل الصورة الديمة
            $path='assets/uploads/Packages/'.$image;
            if(File::exists($path))
             {
                 File::delete($path);
             }  
           
             $file=$request->file('photo');
             $ext=$file->getClientOriginalExtension();
             $filename=time().'.'.$ext;
             $file->move('assets/uploads/Packages',$filename);
             $image=$filename;
        }
         //return response($oldphoto);
         //  $image=$currentuser->photo;
          DB::beginTransaction();
             $packages=array(
              'tripagent_id'=>Auth::user()->id,
              'destination'=>['ar'=>$request->destnation_ar,'en'=>$request->destnation_en],
              'currency_id'=>$request->currency_id,
              'price'=>$request->price,
              'person_num'=>$request->person_num,
              'days'=>$request->days,
              'package_desc'=>['ar'=>$request->package_desc_ar,'en'=>$request->package_desc_en],
              'conditions'=>['ar'=>$request->conditions_ar,'en'=>$request->conditions_en],
              'cancel_conditions'=>['ar'=>$request->cancel_conditions_ar,'en'=>$request->cancel_conditions_en],
              'package_contain'=>['ar'=>$request->package_contain_ar,'en'=>$request->package_contain_en],
              'package_notinclude'=>['ar'=>$request->package_notinclude_ar,'en'=>$request->package_notinclude_en],
              'ReturnPloicy'=>['ar'=>$request->ReturnPloicy_ar,'en'=>$request->ReturnPloicy_en],
              'photo'=>$image,
            );

          $package=Package::where('id',$id)->where('tripagent_id',$user_id)
                   ->update($packages);
          
          DB::commit();
          if(!is_null($package)) {
            return $this->apiResponse($package,'updated',200);
          }
          else
          {
            return $this->apiResponse('','Error in update Data',404);
           }

        }
          catch(\Exception $ex){
            DB::rollBack();
            return response()->json([
                'message' => $ex,
                'user' => 'd'
            ], 404);
        }
         // $packagedesc=['ar'=>$request->packagedesc_ar,'en'=>$request->packagedesc_en];
           

  
          }
    }

   
}
