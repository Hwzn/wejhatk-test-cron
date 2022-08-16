<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\FaviourtTripAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\Tripagent;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class FaviourtTripagentController extends Controller
{
    use ApiResponseTrait;

    public function index($lang,$User_id)
    {
      if(FaviourtTripAgent::where('User_id',$User_id)->exists())
      {
       
       $data=User::select('id',"name as username")
             ->with(['Tripagents'=>function($query) use($lang){
              $query->select('trip_agents.id',"name as Tripagent_Name",'phone','type','photo',"desc->$lang as desc")
                 ->where('trip_agents.verified_at',"!=",Null);
        }])->find($User_id);

        $HostName=request()->getHttpHost();
        $tripagent=array();
       foreach($data->Tripagents as $tripagents)
       {
           $array['user_id']=$data->id;
            $array['user_name']=$data->username;
            $array['Tripagent_id']=$tripagents->id;
            $array['name']=$tripagents->Tripagent_Name;
            $array['phone']=$tripagents->phone;
            $array['type']=$tripagents->type;
            $array['desc']=$tripagents->desc;
            $array['photo']="$HostName/assets/uploads/Profile/TripAgent/".$tripagents->photo;
            array_push($tripagent,$array);
    }
         return $this->apiResponse($tripagent,'ok',200);
      }
      else
      {
        return $this->apiResponse([],'no favouirte found',404);

      }
       
    }

    public function showtripagent($lang,$TripAgent_id)
    {

        if(Tripagent::where('id',$TripAgent_id)->exists())
      {
        // $data=Tripagent::where('id',$TripAgent_id)->first();
            
        $data=Tripagent::select('trip_agents.id',"name as Tripagent_Name",'phone','type','photo',"desc->$lang as desc")
                        ->where('id',$TripAgent_id)
                        ->first();
       $HostName=request()->getHttpHost();
       $tripagent['Tripagent_id']=$data->id;
       $tripagent['name']=$data->Tripagent_Name;
       $tripagent['phone']=$data->phone;
       $tripagent['type']=$data->type;
       $tripagent['desc']=$data->desc;
       $tripagent['photo']="$HostName/assets/uploads/Profile/TripAgent/".$data->photo;


         return $this->apiResponse($tripagent,'ok',200);
      }
      else
      {
        return $this->apiResponse('','Data Not Found',404);

      }
       
    }

    public function store(Request $request)
    {
     
      $validator = Validator::make($request->all(), [
        'User_id' => 'required|exists:users,id',
        'TripAgent_id' => 'required|exists:trip_agents,id',
    ]);

    if ($validator->fails()) 
    {
        return response()->json($validator->errors(), 422);
    }

    $userid=$request->User_id;
    $TripAgent_id=$request->TripAgent_id;
    $favourit_tripag=FaviourtTripAgent::where(function($query) use($userid,$TripAgent_id){
        $query->where('User_id',$userid)
              ->where('TripAgent_id',$TripAgent_id);
    })->first();

    if(!empty($favourit_tripag))
     {
        FaviourtTripAgent::where('User_id',$userid)
              ->where('TripAgent_id',$TripAgent_id)->delete();
        return $this->apiResponse('','Data deleted form favouirte',200);
     }
    else
    {

        $data=FaviourtTripAgent::create([
            'User_id'=>$request->User_id,
            'TripAgent_id'=>$request->TripAgent_id,
        ]);

        if($data):
            return $this->apiResponse($data,'Data Add SuccessFul',200);
        else:
            return $this->apiResponse("",'Error in Save',400);

        endif;

    }
  
        
    }
}
