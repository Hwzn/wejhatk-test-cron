<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use App\Models\Tripagent;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\Booking;
use App\Models\CountryStatistics;
use App\Models\Package;
use App\Models\TripagentsService;
use App\Models\TripagentStatistic;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Support\Collection;

class HomePageController extends Controller
{
    use ApiResponseTrait;

    public function index($lang)
    {
//       $start = new Carbon();
//       $start->startOfMonth();
//       $start->endOfMonth();

// return response($start);
      $lang=strtolower($lang);
        $user_id=Auth::user()->id;
         $data['user_status']=Auth::user()->status;
        $data1=Tripagent::select('id',"name as TripAgent_name",'photo','starnumber','profile_photo')
        ->with(['Services'=>function($query) use($lang){
       $query->select('serivces.id',"name->$lang as service_name",'photo','tripagent_service.status as service_status')
              ->where('serivces.status','active')
              ->orderby('serivces.id','asc');
    }])->find($user_id);
    // return response()->json($data);
    //Service_Count
    //get 
    $TripagentStatistic=TripagentStatistic::select('id','tripagent_id')
    ->orderby('requests_count','DESC')->get()->toarray();
    foreach($TripagentStatistic as $key=>$value)
    {
    $tripagentlogid[]=Auth::user()->id;
    if(in_array($value['tripagent_id'],$tripagentlogid))
    {
      $data['TripagentStatistic_order']=$key+1;
    }
    }

    // countriesStatistic
    $data['countriesStatistic']=CountryStatistics::select('country_statistics.id','country_id',"name->$lang as country_name",'requests_number','country_statistics.created_at','country_statistics.updated_at')
                          ->join('countries','countries.id','country_statistics.country_id')
                          ->whereMonth('country_statistics.created_at',date('m'))
                          ->whereYear('country_statistics.created_at',date('Y'))
                          ->orderby('requests_number','desc')
                          ->take(7)->get();
   // $data['Max_valuecountriesStatis']=CountryStatistics::select('requests_number')
   //                        ->whereMonth('country_statistics.created_at',date('m'))
   //                        ->whereYear('country_statistics.created_at',date('Y'))
   //                        ->orderby('requests_number','desc')
   //                        ->take(1)->get();
   // $data['Min_valuecountriesStatis']=CountryStatistics::select('requests_number')
   //                        ->whereMonth('country_statistics.created_at',date('m'))
   //                        ->whereYear('country_statistics.created_at',date('Y'))
   //                        ->orderby('requests_number','asc')
   //                        ->take(1)->get();
      //  return response()->json($countriesStatistic);
    //
    $data['services_count']=TripagentsService::where('tripagent_id',$user_id)->count();
    $HostName=request()->getHttpHost();
    $data['services']=array();
    $data['requests']=array();

   

    foreach($data1->Services as $Service)
    {
          $array['service_id']=$Service->id;
          $array['service_name']=$Service->service_name;
         if($lang=='en') 
            $array['status']=$Service->service_status=='active'?trans('Service_trans.active',[],'en'):trans('Service_trans.not_active',[],'en');
         else
            $array['status']=$Service->service_status=='active'?trans('Service_trans.active',[],'ar'):trans('Service_trans.not_active',[],'ar');
            array_push($data['services'],$array);

            $req['Serive_id']=$Service->id;
            $req['Serive_name']=$Service->service_name;
            $req['requests_count']=Booking::where('Tripagent_id',$user_id)->where('Service_id',$Service->id)->count();
            array_push($data['requests'],$req);
        
    }

    // $data['Top_PackagePrice']=Package::select('packages.id',"countries.name->$lang as country",'price')
    //                           ->join('countries','countries.id','=','packages.country_id')
    //                           ->where('tripagent_id',$user_id)->orderby('price','desc')->first();
    //  $data['Low_PackagePrice']=Package::select('packages.id',"countries.name->$lang as country",'price')
    //                            ->join('countries','countries.id','=','packages.country_id')
    //                            ->where('tripagent_id',$user_id)->orderby('price','asc')->first();
     
    //$data['Top_PackagePrice']
    $Top_PackagePrice=Package::select('packages.id',"countries.name->$lang as country",'price')
                              ->join('countries','countries.id','=','packages.country_id')
                              ->where('tripagent_id',$user_id)->orderby('price','desc')->first();
        if($Top_PackagePrice !==null)
        {
            $data['Top_PackagePrice']['id']=$Top_PackagePrice->id;
            $data['Top_PackagePrice']['country']=$Top_PackagePrice->country;
            $data['Top_PackagePrice']['price']=$Top_PackagePrice->price;

        }
        else
        {
          $data['Top_PackagePrice']=0;

        }
        //$data['Low_PackagePrice']
     $Low_PackagePrice=Package::select('packages.id',"countries.name->$lang as country",'price')
                               ->join('countries','countries.id','=','packages.country_id')
                               ->where('tripagent_id',$user_id)->orderby('price','asc')->first();
      if($Low_PackagePrice !==null)
        {
            $data['Low_PackagePrice']['id']=$Top_PackagePrice->id;
            $data['Low_PackagePrice']['country']=$Top_PackagePrice->country;
            $data['Low_PackagePrice']['price']=$Top_PackagePrice->price;

        }
        else
        {
          $data['Low_PackagePrice']=0;

        }

  // countriesStatistic_AveragePakages
  $data['countriesaverage_pricepackage']=CountryStatistics::select('country_statistics.id','country_id',"name->$lang as country_name",'averagepackage_price','country_statistics.created_at','country_statistics.updated_at')
  ->join('countries','countries.id','country_statistics.country_id')
  ->whereMonth('country_statistics.created_at',date('m'))
  ->whereYear('country_statistics.created_at',date('Y'))
  ->orderby('averagepackage_price','desc')
  ->take(7)->get();

//   $data['Maxcountriesaverage_pricepacka']=CountryStatistics::select('country_statistics.id','country_id',"name->$lang as country_name",'averagepackage_price','country_statistics.created_at','country_statistics.updated_at')
//   ->join('countries','countries.id','country_statistics.country_id')
//   ->whereMonth('country_statistics.created_at',date('m'))
//   ->whereYear('country_statistics.created_at',date('Y'))
//   ->orderby('averagepackage_price','desc')
//   ->take(1)->get();

//   $data['Mincountriesaverage_pricepacka']=CountryStatistics::select('country_statistics.id','country_id',"name->$lang as country_name",'averagepackage_price','country_statistics.created_at','country_statistics.updated_at')
//   ->join('countries','countries.id','country_statistics.country_id')
//   ->whereMonth('country_statistics.created_at',date('m'))
//   ->whereYear('country_statistics.created_at',date('Y'))
//   ->orderby('averagepackage_price','asc')
//   ->take(1)->get();
  
     if($data)      
     {
      return $this->apiResponse($data,'ok',200);
     }
     else
     {
        return $this->apiResponse("",'No Data Found',404);
     }
    }

    public function shownotification()
    {
        
      $tripagent_id=auth()->user()->id;
      $today=Carbon::now();
      $oldnotification=UserNotification::where('tripagent_id',$tripagent_id)
      ->where('expired_at','<=',$today)  
      ->delete();
   
      $results=UserNotification::select('id','tripagent_id as userid','title',"body as message_content",'expired_at')
         ->where('tripagent_id',$tripagent_id)
          ->where('expired_at','>=',$today)  
        ->get();
   
        
        if(!empty($results))
        {
          return $this->apiResponse($results,'ok',200);
        }    
         else{
       return $this->apiResponse('','No notificaion found',404);
   
      }

    }

   }
