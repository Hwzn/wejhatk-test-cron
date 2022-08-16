<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tripagent;
use App\Models\Serivce;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\TripagentsService;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    use ApiResponseTrait;
    public function myservices($lang)
    {
        $lang=strtolower($lang);
        $user_id=Auth::user()->id;
    //   return response()->json($user);
        $data=Tripagent::select('id',"name as TripAgent_name",'photo','starnumber','profile_photo')
        ->with(['Services'=>function($query) use($lang){
       $query->select('serivces.id',"name->$lang as service_name",'photo','tripagent_service.status as service_status')
              ->where('serivces.status','active');
    }])->find($user_id);
    // return response()->json($data);

    $HostName=request()->getHttpHost();
    $services=array();
    foreach($data->Services as $Service)
    {
        //  $array['tripagent_id']=$data->id;
        //  $array['tripagent_name']=$data->TripAgent;
        //  $array['tripagent_photo']="$HostName/assets/Profile/TripAgent/".$data->photo;
        //  $array['tripagentphoto_profile']="$HostName/assets/uploads/Profile/TripAgent/profile/".$data->profile_photo;
        $array['service_id']=$Service->id;
        $array['service_name']=$Service->service_name;
        $array['photo']="$HostName/assets/uploads/Services/".$Service->photo;
        if($lang=='en' && $Service->service_status=='active')$array['status']='active';
        if($lang=='en' && $Service->service_status=='not_active')$array['status']='not_active';
         if($lang=='ar' && $Service->service_status=='active')$array['status']='مفعل';
        if($lang=='ar' && $Service->service_status=='not_active')$array['status']='غير مفعل';
       
            array_push($services,$array);
 }
     if($services)      
     {
      return $this->apiResponse($services,'ok',200);
     }
     else
     {
        return $this->apiResponse("",'No Data Found',404);
     }
    }

    public function Services_List($lang)
    {
        $lang=strtolower($lang);
        $services=Serivce::select('id',"name->$lang as service_name")
        ->where('status','active')
        ->where('type',"for_all")
        ->orderby('id','asc')->get();
        if($services)      
        {
        return $this->apiResponse($services,'ok',200);
        }
        else
        {
            return $this->apiResponse("",'No Data Found',404);
        }
    }

    public function Add_Service(Request $request)
    {
        $rules=[
            "service_id"=>'required|exists:serivces,id',
        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }
         
          $user_id=Auth::user()->id;
          if((TripagentsService::where('service_id',$request->service_id)->where('tripagent_id',$user_id))->exists())
          {
            return $this->apiResponse("",'Service Alerday Exists',405);
          }
          else
          {
            $data=['service_id'=>$request->service_id,'tripagent_id'=>$user_id];
            $store_data=TripagentsService::create($data);
            if($store_data)
            {
                return $this->apiResponse($store_data,'ok',200);
            }
            else
            {
                return $this->apiResponse("",'error in save data',405);

            }
          }



    }

    public function changeservice_status(Request $request)
    {
        $rules=[
            "service_id"=>'required|exists:serivces,id',
            "status"=>'required'
        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }
         $request_status=$request->status==1?'active':'not_active';

          $user_id=Auth::user()->id;

          if((TripagentsService::where('service_id',$request->service_id)->where('tripagent_id',$user_id))->exists())
          {
            TripagentsService::where('service_id',$request->service_id)->where('tripagent_id',$user_id)
                  ->update([
                     'status'=>$request_status,
                  ]);
                 
                      return $this->apiResponse("",'Status Updated',200);
                  
          }
          else
          {
            return $this->apiResponse("Error",'service not found',404);

          }

    }

    public function deleteservice(Request $request)
    {
        $rules=[
            "service_id"=>'required|exists:serivces,id',
        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }

          $user_id=Auth::user()->id;

          if((TripagentsService::where('service_id',$request->service_id)->where('tripagent_id',$user_id))->exists())
          {
            TripagentsService::where('service_id',$request->service_id)->where('tripagent_id',$user_id)->delete();
              return $this->apiResponse("",'Deleted Serivce Success',200);
                  
          }
          else
          {
            return $this->apiResponse("Error",'error delete service',405);
          }

    }
}
