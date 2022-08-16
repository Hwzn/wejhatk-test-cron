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
use App\Models\CarType;
use App\Models\ConsultationType;
use App\Models\OtherService;
use App\Models\PreferredMethodCommunication;
use App\Models\PreferredTimeCommunication;
use Illuminate\Validation\Rules;

class BookingController extends Controller
{
    use ApiResponseTrait;

    public function bookingform($lang,$Tripagent_id,$Service_id)
    {
  $url=request()->getHttpHost();
   $data['Service_Attribute']=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['attributes'=>function($query) use($lang){
      $query->select('attributes.id',"attributes.name->$lang as attribute_name",'service_attribute.order as order','attribute_types.name as attributetype_name','attr_typeid')
      ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
      ->orderby('order','asc');
   }])->where('id',$Service_id)->first();


    $data['Service_Select']=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['select_types'=>function($query3) use($lang){
      $query3->select('select_types.id',"select_types.name->$lang as selecttype_name","selecttype_elements.name->$lang as select_element")
        ->join('selecttype_elements','selecttype_elements.selecttype_id', '=', 'select_types.id')
        ;
      //  ->orderby('order','asc');
   }])->where('id',$Service_id)->first();


  // $cmment_clecdtin=$data['Service_Select']->select_types;

   $DropDown_Lists=collect($data['Service_Select']->select_types)
   ->groupBy('id');
   // $arr=[];
   // foreach($result as $data)
   // {
   //    $array[$data->selecttype_name]=$data->selecttype_name;
   //    array_push($arr,$array);
   // }



//   // return response()->json(gettype($data['select_types']));
//   $tripagent=array();
//   foreach($cmment_clecdtin as $key=>$data)
//   {
//      $array[$data[$key]][$data['selecttype_name']] =$data['select_element'];
//     array_push($tripagent,$array);
// }
//    return response()->json($tripagent);
 //  $data['Service_Select'];
//  $arr=[];
//      foreach($data_1 as $data)
//      {
       // $array['dd']=$data_1->select_element;
        
   //      array_push($arr,$array);
   //   }
     return response()->json($data['Service_Select']);

   // $data['Service_Select']=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")
   //  ->with('select_types')
   // ->where('id',$Service_id)->first();
      // ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
   //    // ->orderby('order','asc');
   // }])->where('id',$Service_id)->first();
   
   // $data['Service_Select']=Serivce::select('serivces.id',"serivces.name->$lang as serivce_name")->with(['selecttypes'])->get();
   //     ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
   //    //  ->orderby('order','asc');
   //  }])->where('id',$Service_id)->get();
   return response()->json($data['Service_Select']);
   //Tripagent
   $Tripagent=Tripagent::where('id',$Tripagent_id)
                      ->select('id',"name->$lang as Tripagent_name",'photo',"desc->$lang as desc")
                      ->first();
   $data['Tripagents']['id']=$Tripagent->id;
   $data['Tripagents']['name']=$Tripagent->Tripagent_name;
   $data['Tripagents']['photo']="$url/assets/uploads/Profile/TripAgent/".$Tripagent->photo;
   $data['Tripagents']['desc']=$Tripagent->desc;



   //method commincation
   $data['Method_Communication']=PreferredMethodCommunication::select('id',"name->$lang as Method_Way")
    ->orderby('id','desc')
    ->get();

   //Time Comminacation
   $data['Time_Communication']=PreferredTimeCommunication::select('id',"name as TimeCommunication")
   ->orderby('id','asc')
   ->get();
   //carstypes

   if($Service_id==2){
    $data['CarTypes']=CarType::select('id',"name->$lang as car_name")
    ->orderby('id','desc')
    ->where('status','enabled')
    ->get();
   }

   if($Service_id==7){
      $data['Consultions_Types']=ConsultationType::select('id',"name->$lang as Consultions_TypeName")
      ->orderby('id','desc')
      ->get();
     }
  
     if($Service_id==8){
      $data['Other_services']=OtherService::select('id',"name->$lang as OtherSerivce_Name")
      ->orderby('id','desc')
      ->get();
     }

     if($Service_id==4){
      $data['Persons number']=[1,2,3,4,5,6,7,8,9,10];
      $data['child_age']=['1-2','2-4','4-6','6-8','8-10'];
   }
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
      // return response()->json(['Requet'=>$request->service_id]);
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
       foreach ($data as $key=>$value) {
           if (strpos($key, "id")) 
           {
               // $arr1[$key] = $value;
           } else {
               $booking_attribute[$key] = $value;
           }
       }



         $booking=array(
            'User_id'=>$data['user_id'],
            'Service_id'=>$data['service_id'],
            'Tripagent_id'=>$data['tripagent_id'],
            'booking_details'=>json_encode($booking_attribute),
         );
         $booking_store=Booking::create($booking);
         if($booking_store)
         {
            return $this->apiResponse($booking_store,'ok',200);
         }

         else{
            return $this->apiResponse('','Fails',400);

         }
       }
     
    }

    public function getuserbookings($lang,$id)
    {
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

              $booking[$data->id]['Service_Name']=Serivce::where('id',$data->Service_id)->pluck("name->$lang as service_name");
             $booking[$data->id]['Tripagent_name']=Tripagent::where('id',$data->Tripagent_id)->pluck("name->$lang as aa");
            foreach(json_decode($data->booking_details) as $key=>$value)
            {
                $sevice_id=$data->Service_id;
               //  return response()->json($sevice_id);

               $attribute=Attribute::select("attributes.name->$lang as attrb_name",'service_attribute.order','service_attribute.service_id')
                           ->join('service_attribute','service_attribute.attribute_id','=','attributes.id')
                           ->where(function($query) use($key){
                             $query->where('attributes.id',$key);

                           //   where('service_attribute.service_id',$sevice_id)
                            
                           })->first();
                          
              
               // $attribute=Attribute::select("name->$lang as attrb_name",'id')
               //            ->where('attributes.id',$key)
               //            ->first();
               // $attributeorder=ServiceAttruibute::select("service_attribute.order")
               //            ->where('service_attribute.attribute_id',$key)
               //            ->where('service_attribute.service_id',$data->Service_id)
               //            ->pluck('order');   
               // return response()->json(gettype($attributeorder)) ;  
               //  $booking[$data->id][$attribute->attrb_name][$key]=$value;
               $booking[$data->id][$attribute->order]=[$attribute->attrb_name=>$value];

            }

            $booking[$data->id]['Status']=$data->status;
           }
           return $this->apiResponse($booking,'ok',200);

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
}
