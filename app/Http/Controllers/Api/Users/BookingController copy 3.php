<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\Serivce;
use App\Models\Tripagent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\AdsSlideShow;
use App\Models\PlacesToVisit;
use App\Models\ServiceAttruibute;
use App\Models\TermsandCondition;
use App\Models\TourGuide;
use App\Models\TripagentsService;
use App\Models\UsagePolicy;
use Illuminate\Validation\Rules\Exists;

use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Attribute;
use App\Models\BookingPassengerData;
use App\Models\CarType;
use App\Models\ConsultationType;
use App\Models\OtherService;
use App\Models\Package;
use App\Models\PreferredMethodCommunication;
use App\Models\PreferredTimeCommunication;
use Illuminate\Validation\Rules;
use Illuminate\Pagination\Paginator;
use App\Support\Collection;

use App\Http\Controllers\Api\Traits\SendNotificationsTrait;
use App\Models\Country;
use App\Models\CountryStatistics;
use App\Models\DeviceToken;
use App\Models\TripagentStatistic;
use Illuminate\Support\Carbon;
class BookingController extends Controller
{
    use ApiResponseTrait;
    use SendNotificationsTrait;

    public function showall_attribute($lang)
    {
       $data['attributescount']=Attribute::count();
       $data['Attributename']=Attribute::select('attributes.id',"attributes.name->$lang as attribute_name","attribute_types.name as Type")
                             ->join('attribute_types','attribute_types.id',"=",'attributes.attr_typeid')
                             ->orderby('attributes.id','asc')
                             ->get();
      
       if(!is_null($data)) 
   {
      return $this->apiResponse($data,'ok',200);
   }   
   else{
      return $this->apiResponse('','No Data Found',404);

   }

    }
    public function bookingform($lang,$Tripagent_id,$Service_id)
    {
  $url=request()->getHttpHost();
   $data['Service_Attribute']=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['attributes'=>function($query) use($lang){
      $query->select('attributes.id',"attributes.name->en as attribute_name",'service_attribute.order as order','attribute_types.name as attributetype_name')
      ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
      ->orderby('order','asc');
   }])->where('id',$Service_id)->first();

//pakcages
if($Service_id=='1')
{
   $data['Tripagent_Packages']=Tripagent::select('trip_agents.id',"trip_agents.name->$lang as tripagent_name")->with(['Packages'=>function($query) use($lang){
      $query->select('packages.id as package_id',"packages.destination->$lang as package",'packages.price',"currencies.short_name->$lang as currency","packages.person_num->$lang as Persons_number",'packages.days'
      ,'packages.rate',"packages.package_desc->$lang as 'package_desc'","packages.package_contain->$lang as 'package_contain'"
      ,"packages.conditions->$lang as 'conditions'","packages.cancel_conditions->$lang as 'cancel_conditions'")
      ->join('currencies','currencies.id', '=', 'packages.currency_id')
      ->where('packages.status','=','active')
       ->orderby('packages.id','asc');
   }])->where('id',$Tripagent_id)->first();
   
   if(($data['Tripagent_Packages']->Packages)->count()>0)
   {
    
   $data['pakcages_destination']=Package::select("packages.destination->$lang as package")
   ->where('status','active')->pluck('package');
   $data['pakcages_nigthsnumber']=Package::select("packages.days")
   ->where('status','active')->distinct()
   ->pluck('days');  
   $data['pakcages_maxnprice']=Package::where('status','active')
         ->max('packages.price');
   $data['pakcages_minnprice']=Package::where('status','active')
   ->min('packages.price');       
   }
}

                     
   //Tripagent
   $Tripagent=Tripagent::where('id',$Tripagent_id)
                      ->select('id',"name->$lang as Tripagent_name",'photo',"desc->$lang as desc")
                      ->first();
   $data['Tripagents']['id']=$Tripagent->id;
   $data['Tripagents']['name']=$Tripagent->Tripagent_name;
   $data['Tripagents']['photo']="$url/assets/uploads/Profile/TripAgent/".$Tripagent->photo;
   $data['Tripagents']['desc']=$Tripagent->desc;

   $Service_Select=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['select_types'=>function($query3) use($lang){
      $query3->select('select_types.id',"select_types.name->en as DropDownType","selecttype_elements.name->$lang as DropDownValue")
        ->join('selecttype_elements','selecttype_elements.selecttype_id', '=', 'select_types.id');
   }])->where('id',$Service_id)->first();

   $data['DropDown_Lists']=collect($Service_Select->select_types)
   ->groupBy('DropDownType')->toArray();
   
   //  $arr=[];
   // foreach($data['DropDown_Lists'] as $key=>$value)
   // {
   //    array_push($arr,$value);
   //    foreach($value as $data)
   //    {
   //       $array[$key]=$data['DropDownValue'];
   //       array_push($arr,$array);

   //    }

   // }
  // return response()->json($arr);

  // return response()->json($data['DropDown_Lists']);

   if(!is_null($data)) 
   {
      return $this->apiResponse($data,'ok',200);
   }   
   else{
      return $this->apiResponse('','No Data Found',404);

   }
    }

    //

    public function Tourguide_Consultionform($lang,$Trouguide_id)
    {
  $url=request()->getHttpHost();
   $data['Service_Attribute']=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['attributes'=>function($query) use($lang){
      $query->select('attributes.id',"attributes.name->en as attribute_name",'service_attribute.order as order','attribute_types.name as attributetype_name')
      ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
      ->orderby('order','asc');
   }])->where('id',7)->first();

//pakcages

                     
   //Tourguide
   $Tourguide=TourGuide::where('id',$Trouguide_id)
                      ->select('id',"name->$lang as Tourguide_name",'photo',"desc->$lang as desc")
                      ->first();
   $data['Tourguide']['id']=$Tourguide->id;
   $data['Tourguide']['name']=$Tourguide->Tripagent_name;
   $data['Tourguide']['photo']="$url/assets/uploads/Profile/TourGuide/".$Tourguide->photo;
   $data['Tourguide']['desc']=$Tourguide->desc;

   $Service_Select=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['select_types'=>function($query3) use($lang){
      $query3->select('select_types.id',"select_types.name->en as DropDownType","selecttype_elements.name->$lang as DropDownValue")
        ->join('selecttype_elements','selecttype_elements.selecttype_id', '=', 'select_types.id');
   }])->where('id',7)->first();

   $data['DropDown_Lists']=collect($Service_Select->select_types)
   ->groupBy('DropDownType')->toArray();
   

   if(!is_null($data)) 
   {
      return $this->apiResponse($data,'ok',200);
   }   
   else{
      return $this->apiResponse('','No Data Found',404);

   }
    }
    //
      public function quick_requestform($lang)
      {
         $url=request()->getHttpHost();
         $data['Service_Attribute']=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['attributes'=>function($query) use($lang){
            $query->select('attributes.id',"attributes.name->en as attribute_name",'service_attribute.order as order','attribute_types.name as attributetype_name')
            ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
            ->orderby('order','asc');
         }])->where('id',9)->first();
      
     
         
         $Service_Select=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['select_types'=>function($query3) use($lang){
            $query3->select('select_types.id',"select_types.name->en as DropDownType","selecttype_elements.name->$lang as DropDownValue")
              ->join('selecttype_elements','selecttype_elements.selecttype_id', '=', 'select_types.id');
         }])->where('id',9)->first();
      
         $data['DropDown_Lists']=collect($Service_Select->select_types)
         ->groupBy('DropDownType')->toArray();
      
         if(!is_null($data)) 
         {
            return $this->apiResponse($data,'ok',200);
         }   
         else{
            return $this->apiResponse('','No Data Found',404);
      
         }
      }
    public function storebooking(Request $request)
    {
      // $validator=Validator::make($request->all(),[
      //    //'password' => Rules::when(request()->has('password'), ['required','min:6']),
      //    'service_id' => 'sometimes|required|exists:serivces,id',
      //    'Tripagent_id' => 'sometimes|required|exists:trip_agents,id',
      //    // '10' => 'sometimes|required',
      //    // '11' => 'sometimes|required',
      //    // '12' => 'sometimes|required',
      //    // '13' => 'sometimes|required',
      //    // '14' => 'sometimes|required',
      // ]);

     
      // if($validator->fails())
      // {
      //    return response()->json($validator->errors(), 400);
      //  }

      try{
         DB::beginTransaction();

         
         DB::commit();
         return response()->json([
                     'message' => 'HelpRequest Send successfully',
                     'user' => $user
                 ], 201);
      }
      catch(\Exception $ex){
         DB::rollBack();
         return response()->json([
             'message' => $ex,
         ], 404);
     }

      // else{
         $data=$request->all();
         $booking_attribute = array();    
        // $booking_attribute = array_map('utf8mb4_unicode_ci', $booking_attribute);
       foreach ($data as $key=>$value) {
           if (strpos($key, "id") || strpos($key, "hild_data") || strpos($key, "raveller_data") ) 
           {
               // $arr1[$key] = $value;
           } else {
               $booking_attribute[$key] = $value;
           }
       }

     // }
      
     $package_id='';
     //  if(!empty($data['packaged_id']))  $package_id=$data['packaged_id']; else $package_id=Null;
       if(!empty($data['packaged_id'])) 
       {
          $package_id=$data['packaged_id'];

          //add Country Statistics
          $country=Package::select('country_id')->where('id',$package_id)->first();
          $country_id=$country->country_id;

          if(CountryStatistics::where('country_id',$country_id)
          ->whereMonth('created_at',date('m'))
          ->whereYear('created_at',date('Y'))->exists())
          {
            $country_statiistics=CountryStatistics::where('country_id',$country_id)
            ->whereMonth('created_at',date('m'))
            ->whereYear('created_at',date('Y'))->first();
            $country_statiistics->update([
               'requests_number'=>$country_statiistics->requests_number+1,
            ]);
          }
          else
          {
            $country_statiistics=['country_id'=>$country_id,'requests_number'=>1];
            CountryStatistics::create($country_statiistics);

          }
            // return response('fffff');
       }  
       else
       {
          $package_id=Null;
       } 
       $tripagent_id='';
   //if(!empty($data['tripagent_id']))  $tripagent_id=$data['tripagent_id']; else $tripagent_id=Null;
   if(!empty($data['tripagent_id'])) 
   {
      $tripagent_id=$data['tripagent_id'];
         if(TripagentStatistic::where('tripagent_id',$tripagent_id)->exists())
         {
         $trip_statiistics=TripagentStatistic::where('tripagent_id',$tripagent_id)->first();
         $trip_statiistics->update([
            'requests_count'=>$trip_statiistics->requests_count+1,
         ]);
         }
         else
         {
         $trip_statiistics=['tripagent_id'=>$tripagent_id,'requests_count'=>1];
         TripagentStatistic::create($trip_statiistics);

         }
   }  
   else
   {
      $tripagent_id=Null;
   } 
   //  $service=Serivce::select('id','name')->where('id',$data['service_id'])->first();
    $service=Serivce::select('name')->where('id',$data['service_id'])->first()->toarray();
    //$service_name=$service[0];
   // return response()->json($service['name']);
    $service_ar=$service['name']['ar'];
    $service_en=$service['name']['en'];
   // return response()->json($service_ar);

         $booking=array(
            'User_id'=>$data['user_id'],
            'Service_id'=>$data['service_id'],
            'Tripagent_id'=>$tripagent_id,
            'Package_id'=>$package_id,
            'booking_details'=>json_encode($booking_attribute,JSON_UNESCAPED_UNICODE),
         );
         $booking_store=Booking::create($booking);
        // $est=$data['child_data'];
         // $array=explode(' ',$est[1]);
        // return response()->json(json_decode($data['child_data']));

         if($booking_store)
         {
            $booking=Booking::select('id')->where('User_id',$data['user_id'])->latest('id')->first();
              if(isset($data['child_data']))
               {

                  foreach($data['child_data'] as $key=>$value)
                  {
                     
                     $booking_passanger=BookingPassengerData::create([
                         'booking_id'=>$booking->id,
                         'name'=>$value['name'],
                         'age'=>$value['age'],
                         'type'=>'child',
                     ]);
                     
                  }  
               }
               if(isset($data['traveller_data']))
               {

                  foreach($data['traveller_data'] as $key=>$value)
                  {
                     
                     $booking_passanger=BookingPassengerData::create([
                         'booking_id'=>$booking->id,
                         'name'=>$value['name'],
                         'age'=>$value['age'],
                         'phone'=>$value['phone'],
                         'type'=>'adult',
                     ]);
                     
                  }  
               }

             //notficaions
             if($tripagent_id !==Null)
             {
                //send notifucation for tripagent
                $user_name=Auth::user()->name;
                $user_tokens=DeviceToken::where('tripagent_id',$tripagent_id)->pluck('token')->toarray();
                $noification_title="Booking Reuest notification";
                $notification_body=$user_name .' '.' Send Booking Request  Number '.'#'.$booking->id ;
                // return response()->json($notification_body);
                $message_content=[
                   'en'=>$user_name .' '.' Send '.$service_en. ' with booking number '.'#'.$booking->id,
                  //  'ar'=>'تم ارسال طلب ' . $service_name . 'من ' . $user_name . 'برقم # ' . $booking->id
                   'ar'=>"تم ارسال طلب  $service_ar  من  $user_name برقم #$booking->id"
                  ];
               $this->sendnotification(null,$request->tripagent_id,$noification_title,$notification_body,$user_tokens,$message_content);
                   //sendnotifaction for admin
                  
             }
 
            
            return $this->apiResponse($booking_store,'data saved succefuly',200);
           
          
           
          }
           

  }
      

////

public function storeconsultion_tourguiderequest(Request $request)
{
  $validator=Validator::make($request->all(),[
     //'password' => Rules::when(request()->has('password'), ['required','min:6']),
     'service_id' => 'sometimes|required|exists:serivces,id',
     'Tripagent_id' => 'sometimes|required|exists:trip_agents,id',
     // '10' => 'sometimes|required',
     // '11' => 'sometimes|required',
     // '12' => 'sometimes|required',
     // '13' => 'sometimes|required',
     // '14' => 'sometimes|required',
  ]);

 
  if($validator->fails())
  {
     return response()->json($validator->errors(), 400);
   }

   else{
     $data=$request->all();
// return response()->json($data);
     $booking_attribute = array();    
    // $booking_attribute = array_map('utf8mb4_unicode_ci', $booking_attribute);
   foreach ($data as $key=>$value) {
       if (strpos($key, "id") || strpos($key, "hild_data") || strpos($key, "raveller_data") ) 
       {
           // $arr1[$key] = $value;
       } else {
           $booking_attribute[$key] = $value;
       }
   }

}
     // return response()->json($booking_attribute);
 $package_id=null;
 $tripagent_id=null;

     $booking=array(
        'User_id'=>$data['user_id'],
        'Service_id'=>7,
        'Tripagent_id'=>$tripagent_id,
        'Tourguide_id'=>$data['Tourguide_id'],
        'Package_id'=>$package_id,
        'booking_details'=>json_encode($booking_attribute,JSON_UNESCAPED_UNICODE),
     );
     $booking_store=Booking::create($booking);
     if($booking_store)
     {
        return $this->apiResponse($booking_store,'data saved succefuly',200);
     }

     else{
        return $this->apiResponse('','Fails',400);

     }
   }
 


       
    public function getuserbookings($lang,$id)
    {
      $HostName=request()->getHttpHost();

       if(Booking::where('User_id',$id)->exists())
       {
         $data['booking']=Booking::where('User_id',$id)->get();
        $booking=[];
           foreach($data['booking'] as $data)
           {
              $booking[$data->id]['booking_id']=$data->id;
              $booking[$data->id]['User_id']=$data->User_id;
              $booking[$data->id]['Service_id']=$data->Service_id;
             // return response()->json($data->Service_id);

            //   $booking[$data->id]['Service_Name']=Serivce::where('id',$data->Service_id)->pluck("name->$lang as service_name");
              $service=Serivce::where('id',$data->Service_id)
              ->select('id',"name->$lang as service_name")
              ->first();
              $booking[$data->id]['Service_Name']=$service->service_name;

              $Tripagent=Tripagent::select('id',"name->$lang as name",'photo')->where('id',$data->Tripagent_id)->first();
              $booking[$data->id]['Tripagent_name']=$Tripagent->name;
              $booking[$data->id]['Tripagent_photo']="$HostName/public/assets/uploads/Profile/TripAgent/".$Tripagent->photo;
              $booking[$data->id]['Status']=$data->status;

              $booking[$data->id]['bookings_details']=[];

              foreach(json_decode($data->booking_details) as $key=>$value)
            {
                $sevice_id=$data->Service_id;
               //  return response()->json($sevice_id);

               $attribute=Attribute::select("attributes.name->en as attrb_name",'service_attribute.order','service_attribute.service_id')
                           ->join('service_attribute','service_attribute.attribute_id','=','attributes.id')
                           
                           ->where(function($query) use($key){
                             $query->where('attributes.id',$key);
                           //   where('service_attribute.service_id',$sevice_id)
                           })->orderby('order','desc')
                           ->first();
                          
                 
               $array[$data->id][$attribute->order]=[$attribute->attrb_name=>$value];
             array_push($booking[$data->id]['bookings_details'],$array[$data->id][$attribute->order]);
            }

           }
           return $this->apiResponse($booking,'ok',200);

       }
       else{
         return $this->apiResponse('','Data Booking Not Found',404);
      }
    }
    
    public function userbookings($lang,$id,$page)
    {
     
      $HostName=request()->getHttpHost();
    $lang=strtolower($lang);
       if(Booking::where('User_id',$id)->exists())
       {
         $data['booking']=Booking::where('User_id',$id)
         ->get();
     //   return response()->json($data['booking']);
        $booking=[];

           foreach($data['booking'] as $data)
           {
              $booking[$data->id]['booking_id']=$data->id;
              $booking[$data->id]['User_id']=$data->User_id;
              $booking[$data->id]['Service_id']=$data->Service_id;

           
               $service=Serivce::where('id',$data->Service_id)
              ->select('id',"name->$lang as service_name")
              ->first();
              $booking[$data->id]['Service_Name']=$service->service_name;

              if(!$data->Tripagent_id==Null)
              {
               $Tripagent=Tripagent::select('id',"name->$lang as name",'photo')->where('id',$data->Tripagent_id)->first();
               $booking[$data->id]['Tripagent_id']=$Tripagent->id;
               $booking[$data->id]['Tripagent_name']=$Tripagent->name;
               $booking[$data->id]['Tripagent_photo']="$HostName/public/assets/uploads/Profile/TripAgent/".$Tripagent->photo;
              }
              elseif(!$data->Tourguide_id==Null)
              {
               $Tourguide=TourGuide::select('id',"name",'photo')->where('id',$data->Tourguide_id)->first();
               $booking[$data->id]['Tourguide_id']=$Tourguide->id;
               $booking[$data->id]['Tourguide_name']=$Tourguide->name;
               $booking[$data->id]['Tourguide_photo']="$HostName/public/assets/uploads/Profile/TourGuide/".$Tourguide->photo;
              }

              else
              {
               $booking[$data->id]['Tripagent_name']='Admin';
              }
            
             if($lang=='ar' && $data->status=='pending')
             {
               $booking[$data->id]['Status']='تحت المراجعة';
             }
             elseif($lang=='ar' && $data->status=='completed')
             {
               $booking[$data->id]['Status']='تم التأكيد';
             }
             elseif($lang=='ar' && $data->status=='refused')
             {
               $booking[$data->id]['Status']='مرفوض';
             }
             else{
               $booking[$data->id]['Status']=$data->status;
             }
              $booking[$data->id]['Created_at']=$data->created_at;
              $booking[$data->id]['Updated_at']=$data->updated_at;

              
           }
          $results = (new Collection($booking))->paginate(10,0,$page);
          if(!empty($results->count()>0))  
          {
            return $this->apiResponse($results,'ok',200);
          }    
          else{
            return $this->apiResponse("",'Thepervious page  is Last Page',200);

          }  

       }
       else{
         return $this->apiResponse('','Data Booking Not Found',404);
      }
    }  

    public function getcars($lang)
    {
       $data=CarType::select('id',"name->$lang as car_name")
                     ->orderby('id','desc')
                     ->where('status','enabled')
                     ->get();
      if($data->count()>0)
      {
         return $this->apiResponse($data,'ok',200);

      }
      else{
         return $this->apiResponse('','Data  Not Found',404);
      }
    }


    public function package_filter(Request $request,$lang)
    {
      $lang=strtolower($lang);
      $search=$request->all();
      // return response()->json($search);
      if(isset($search['days']) && $search['days']!='null') $days=$search['days'];else $days='all';
      if(isset($search['destination']) && $search['destination']!='null') $destination=$search['destination'];else $destination='all';

      if(isset($search['fromprice']) && $search['fromprice']!='null') $fromprice=$search['fromprice'];else $fromprice='all';
      if(isset($search['toprice']) && $search['toprice']!='null') $toprice=$search['toprice'];else $toprice='all';

      $data=Package::select('packages.id as package_id',"packages.destination->$lang as package",'packages.price',"currencies.short_name->$lang as currency","packages.person_num->$lang as Persons_number",'packages.days'
         ,'packages.rate',"packages.package_desc->$lang as 'package_desc'","packages.package_contain->$lang as 'package_contain'"
         ,"packages.conditions->$lang as 'conditions'","packages.cancel_conditions->$lang as 'cancel_conditions'")
         ->join('currencies','currencies.id', '=', 'packages.currency_id')
         ->where('packages.status','=','active')
         ->where(function($query) use($days,$destination,$fromprice,$toprice,$lang){
            if($days!=='all')
            {
               $query->where('packages.days','=',$days);
            }
            if($destination!=='all')
            {
               $query->where("packages.destination->$lang",'=',$destination);
            }
            if($fromprice!=='all' && $toprice!=='all')
            {
               $query->where("packages.price",'>=',$fromprice)
                     ->where("packages.price",'<=',$toprice);

            }
            if($fromprice!=='all' && $toprice =='all')
            {
               $query->where("packages.price",'>=',$fromprice)
                     ->where("packages.price",'<=',$fromprice);

            }
            
            if($fromprice =='all' && $toprice !=='all')
            {
               $query->where("packages.price",'>=',0)
                     ->where("packages.price",'<=',$toprice);

            }
         })
          ->orderby('packages.id','asc')
          ->paginate(10);
          
          if($data->count()>0)
          {
             return $this->apiResponse($data,'ok',200);
    
          }
          else{
             return $this->apiResponse('','Data  Not Found',404);
          }
    }
   }

