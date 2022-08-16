<?php

namespace App\Http\Controllers\Api\Tourguide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\ConsultionTypeTourguide;
use Illuminate\Support\Facades\Validator;

use App\Models\ConsultationType;
class MyConsultionTypeController extends Controller
{
    use ApiResponseTrait;

    public function allConsultionsType($lang)
    {
        $lang=strtolower($lang);
        $user_id=Auth::user()->id;
        $data=ConsultationType::select('id',"name->$lang as conultion_name")
        ->where('type','tourguide')
        ->where('status','active')
        ->get();
        if(!$data==null)      
        {

        return $this->apiResponse($data,'ok',200);
        }
        else
        {
        return $this->apiResponse('j','No Data Found',404);
        }
    }
    public function myconsutlions($lang)
    {
        $lang=strtolower($lang);
        $user_id=Auth::user()->id;
        $HostName=request()->getHttpHost();

        $data_con=ConsultionTypeTourguide::select('consultiontype_tourguide.id',"consultation_types.name->$lang as type_name",'consultiontype_tourguide.status')
        ->join('consultation_types','consultation_types.id','=','consultiontype_tourguide.consultiontype_id')
       ->where('tourguide_id',$user_id)
       ->where('consultation_types.status','active')->get();
      
       $data=[];
       foreach($data_con as $data_cons)
       {
            $array['id']=$data_cons->id;
            $array['type_name']=$data_cons->type_name;
            $array['status']=$data_cons->status;
            $array['service_photo']="$HostName/public/assets/uploads/Services/Consultation.png";
            array_push($data,$array);
           
       }

     if($data)      
     {

      return $this->apiResponse($data,'ok',200);
     }
     else
     {
        return $this->apiResponse([],'No Data Found',404);
     }
    }

    
    public function Add_consultiontype(Request $request)
    {
        $rules=[
            "type_id"=>'required|exists:consultation_types,id',
        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }
         
          $user_id=Auth::user()->id;
          if((ConsultionTypeTourguide::where('consultiontype_id',$request->type_id)->where('tourguide_id',$user_id))->exists())
          {
            return $this->apiResponse([],'consultiontype Alerday Exists',405);
          }
          else
          {
            $data=['consultiontype_id'=>$request->type_id,'tourguide_id'=>$user_id];
            $store_data=ConsultionTypeTourguide::create($data);
            if($store_data)
            {
                return $this->apiResponse($store_data,'ok',200);
            }
            else
            {
                return $this->apiResponse([],'error in save data',405);

            }
          }



    }

    public function changeconsult_status(Request $request)
    {
        $rules=[
            "type_id"=>'required|exists:consultiontype_tourguide,id',
            "status"=>'required'
        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }
         $request_status=$request->status==1?'active':'not_active';

          $user_id=Auth::user()->id;

          if((ConsultionTypeTourguide::where('id',$request->type_id)->where('tourguide_id',$user_id))->exists())
          {
            ConsultionTypeTourguide::where('id',$request->type_id)->where('tourguide_id',$user_id)
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

    public function delete_consultiontype(Request $request)
    {
        $rules=[
            "type_id"=>'required|exists:consultiontype_tourguide,id',
        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }

          $user_id=Auth::user()->id;

          if((ConsultionTypeTourguide::where('id',$request->type_id)->where('tourguide_id',$user_id))->exists())
          {
            ConsultionTypeTourguide::where('id',$request->type_id)->where('tourguide_id',$user_id)->delete();
              return $this->apiResponse("",'Deleted  Success',200);
                  
          }
          else
          {
            return $this->apiResponse([],'error delete',405);
          }

    }
}

