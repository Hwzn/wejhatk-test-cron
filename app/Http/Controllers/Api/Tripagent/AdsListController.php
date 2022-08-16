<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use App\Models\AdsList;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\AdsListDetails;
use App\Models\AdsRequests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdsListController extends Controller
{
    use ApiResponseTrait;

    public function  Ads_ListForm($lang)
    {
        $appearance_order=AdsList::select('ads_lists.appearance_order')->distinct()
        // ->join('adslist_details','adslist_details.appearance_order','=','ads_lists.appearance_order')
        // ->pluck('appearance_order');
        ->get();
        $Myads['appearance_order']=[];
        foreach($appearance_order as $key=>$ad_list)
        {
             $ads_listapperqancecount=AdsRequests::where('appearance_order',$ad_list->appearance_order)
             ->where('status','!=','expired')
             ->count();
            // return response()->json($ads_listapperqancecount);
            if($ads_listapperqancecount<=3)
            {
                $array[$key]=$ad_list->appearance_order;
                array_push($Myads['appearance_order'],$array[$key]);
            }
           
        }
        $Myads['duration']=AdsList::select("duration->$lang as durations")
        ->distinct()
        ->pluck('durations');
        if($Myads)      
        {
        return $this->apiResponse($Myads,'ok',200);
        }
        else
        {
        return $this->apiResponse("",'No Data Found',404);
        }
    }
    public function get_adsPrice($order,$duration,$lang)
    {
        $lang=strtolower($lang);

        $Myads=AdsList::select('ads_lists.id as ads_id','appearance_order',"duration",'price','currency_id'
         ,"currencies.short_name->$lang as currency")
        ->join('currencies','currencies.id','=','ads_lists.currency_id')
        ->where('appearance_order',$order)
        ->where("duration->$lang",$duration)
        ->first();
      
        if($Myads)      
        {
            $data['id']=$Myads->ads_id;
            $data['appearance_order']=$Myads->appearance_order;
            $data['duration']=$Myads->duration;
            $data['price']=$Myads->price .' '. $Myads->currency;
            $data['currency_id']=$Myads->currency_id;

        return $this->apiResponse($data,'ok',200);
        }
        else
        {
        return $this->apiResponse("",'No Data Found',404);
        }
    }

    public function store_adsListrequest(Request $request)
    {   
        $user_id=Auth::user()->id;
        $rules=[
            'duration' => 'required|',
            'actual_price' => 'required|numeric',
            'appearance_order' => 'required|integer',
            'currency_id' => 'required|exists:currencies,id',

        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }
        
          try 
          {
              DB::beginTransaction(); 
     
    //for expire_at
      $expire_date=null;
       if($request->duration=='week' || $request->duration=='أسبوع')$expire_date=Carbon::now()->addDays(7);
       if($request->duration=='month' || $request->duration=='شهر')$expire_date=Carbon::now()->addMonth();
       if($request->duration=='quarter_year' || $request->duration=='ربع سنه')$expire_date=Carbon::now()->addMonths(3);
       if($request->duration=='Year' || $request->duration=='سنة')$expire_date=Carbon::now()->addYear();

                $ads=AdsRequests::create([
                      'adstype_id'=>3,
                      'tripagent_id'=>$user_id,
                      'agency_name'=>Auth::user()->name,
                      'phone'=>Auth::user()->phone,
                      'appearance_order'=>$request->appearance_order,
                      'duration'=>$request->duration,
                      'actual_price'=>$request->price,
                      'currency_id'=>$request->currency_id,
                      'expire_at'=>$expire_date,
                  ]);
                  
              DB::commit();
                return response()->json([
              'message' => 'request successfully send',
              'user' => $ads
          ], 201);
              }
              catch(\Exception $ex){
                  DB::rollBack();
                  return response()->json([
                      'message' => $ex,
                      'user' => 'd'
                  ], 404);
              }

    }
}
