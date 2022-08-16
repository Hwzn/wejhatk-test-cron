<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpRequest;
use App\Models\Help;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Support\Collection;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\TourGuide;
use App\Models\Tripagent;
use App\Models\User;

class HelpRequestController extends Controller
{
    use ApiResponseTrait;
   public function FormHelpRequest($lang)
   {
       $FormHelp=Help::select('id',"name->$lang as Problem_Type")->orderby('id','desc')->get();
       if($FormHelp->count()>0)
       {
           return response()->json([
               'MSG'=>'ok',
               'data'=>$FormHelp,
           ],200);
       }
       else
       {
        return response()->json([
            'MSG'=>'No Data Found',
            'data'=>'',
        ],404);
       }
       
   }
    public function send_helprequest(Request $request)
    {
        // $user=Auth::user();
      // return  response(Auth::getDefaultDriver());
     

       if($request->guardkey=='user_1')
       {
        // $user=Auth::user();
        if(User::where('id',$request->user_id)->exists())
        {
            $helpimage="";
            $rand_num=mt_rand(100000000,999999999);
            $validator = Validator::make($request->all(), [
                'help_id' => 'required|exists:helps,id',
                'user_id' => 'required|exists:users,id',
                'request_details' => 'required|min:5',
                'photo'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            try{
                DB::beginTransaction();
         
                 if($request->hasfile('photo')) 
                 {
                      $file=$request->file('photo');
                      $ext=$file->getClientOriginalExtension();
                      $filename=$rand_num.'.'.$ext;
                      $file->move('public/assets/uploads/HelpRequests/UsersHelpRequest',$filename);
                      $helpimage=$filename;
    
                 }
             
                 $user=HelpRequest::create([
                     'ticket_num'=>'#'.$rand_num,
                     'user_id'=>$request->user_id,
                     'help_id'=>$request->help_id,
                     'request_details'=>$request->request_details,
                     'request_photo'=>$helpimage,
                 ]);
         
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
                     'user' => 'd'
                 ], 404);
             }
         
        }
        else{
            return response()->json('user not found', 422);

        }
       
       }
       elseif($request->guardkey=='tripagent_1')
       {
        if(Tripagent::where('id',$request->user_id)->exists())
        {

            $helpimage=null;
            $rand_num=mt_rand(100000000,999999999);
            $validator = Validator::make($request->all(), [
                'help_id' => 'required|exists:helps,id',
                'user_id' => 'required|exists:trip_agents,id',
                'request_details' => 'required|min:5',
                'photo'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            try{
                DB::beginTransaction();
         
                 if($request->hasfile('photo')) 
                 {
                      $file=$request->file('photo');
                      $ext=$file->getClientOriginalExtension();
                      $filename=$rand_num.'.'.$ext;
                      $file->move('public/assets/uploads/HelpRequests/TripagentsHelpRequest',$filename);
                      $helpimage=$filename;
    
                 }
             
                 $user=HelpRequest::create([
                     'ticket_num'=>'#'.$rand_num,
                     'tripagent_id'=>$request->user_id,
                     'help_id'=>$request->help_id,
                     'request_details'=>$request->request_details,
                     'request_photo'=>$helpimage,
                 ]);
         
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
                     'user' => 'd'
                 ], 404);
             }
        }
        else
        {
            return response()->json('user not found', 422);

        }

        
       }
       elseif($request->guardkey=='tourguide_1')
       {
        //return response('tour');
        if(TourGuide::where('id',$request->user_id)->exists())
        {
            $helpimage=null;
        $rand_num=mt_rand(100000000,999999999);
        $validator = Validator::make($request->all(), [
            'help_id' => 'required|exists:helps,id',
            'user_id' => 'required|exists:tour_guides,id',
            'request_details' => 'required|min:5',
            'photo'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            DB::beginTransaction();
     
             if($request->hasfile('photo')) 
             {
                  $file=$request->file('photo');
                  $ext=$file->getClientOriginalExtension();
                  $filename=$rand_num.'.'.$ext;
                  $file->move('public/assets/uploads/HelpRequests/TourguidesHelpRequest',$filename);
                  $helpimage=$filename;

             }
         
             $user=HelpRequest::create([
                 'ticket_num'=>'#'.$rand_num,
                 'tourguide_id'=>$request->user_id,
                 'help_id'=>$request->help_id,
                 'request_details'=>$request->request_details,
                 'request_photo'=>$helpimage,
             ]);
     
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
                 'user' => 'd'
             ], 404);
         }
 
        }
        else
        {
            return response()->json('user not found', 422);

        }
        
       }
      

    }

    public function showhelprequests($lang,$guardkey,$userid)
    {

  if($guardkey=='user_1')
        {
          $user=User::where('id',$userid)->first();
           $user_id=$user->id;
               if(HelpRequest::where('help_requests.user_id',$user_id)->exists())
        {
             $data['helprequests']=HelpRequest::select('help_requests.*',"helps.name->$lang as 'help_name'")
        ->where('help_requests.user_id',$user_id)
        ->join('helps','help_requests.help_id', '=', 'helps.id')
        ->get();

        $helprequest=array();
        $HostName=request()->getHttpHost();
        if($data['helprequests']->count()>0)
        {
           foreach($data['helprequests'] as $data)
           {
              $array['id']=$data->id;
              $array['ticket_num']=$data->ticket_num;
              $array['user_id']=$data->user_id;
              $array['help_id']=$data->help_id;
              $array['request_details']=$data->request_details;
              $array['status']=$data->status;
              if($data->status !=='pending')
              {
                $array['admin_reply']=$data->admin_reply;
              }
             $array['created_at']=$data->created_at;
            $array['updated_at']=$data->updated_at;

              $array['photo']="$HostName/public/assets/uploads/UserHelpRequests/".$data->request_photo;
              array_push($helprequest,$array);
           }
       
         
             return response()->json([
                'message' => 'ok',
                'data' => $helprequest
            ], 201);
        }
        
        else
        {
             return response()->json([
                'message' => 'No Data Found',
                'data' => ''
            ], 404);
        }
     
       
    }
    else
    {
        return response()->json([
                'message' => 'user not Found',
                'data' => ''
            ], 404);
    }
    
            
        }

        
        elseif($guardkey=='tripagent_1')
        {
            $user=Tripagent::where('id',$userid)->first();
            $user_id=$user->id;
           if(HelpRequest::where('help_requests.tripagent_id',$user_id)->exists())
            {
                 $data['helprequests']=HelpRequest::select('help_requests.*',"helps.name->$lang as 'help_name'")
            ->where('help_requests.tripagent_id',$user_id)
            ->join('helps','help_requests.help_id', '=', 'helps.id')
            ->get();
    
            $helprequest=array();
            $HostName=request()->getHttpHost();
            if($data['helprequests']->count()>0)
            {
               foreach($data['helprequests'] as $data)
               {
                  $array['id']=$data->id;
                  $array['ticket_num']=$data->ticket_num;
                  $array['user_id']=$data->tripagent_id;
                  $array['help_id']=$data->help_id;
                  $array['request_details']=$data->request_details;
                  $array['status']=$data->status;
                  if($data->status !=='pending')
                  {
                    $array['admin_reply']=$data->admin_reply;
                  }
                  $array['created_at']=$data->created_at;
                  $array['updated_at']=$data->updated_at;
                  if(!is_null($data->request_photo))
                  {
                    $array['photo']="$HostName/public/assets/uploads/HelpRequests/TripagentsHelpRequest/".$data->request_photo;
                  }
                  array_push($helprequest,$array);
               }
           
             //paginate
               if(!empty($helprequest))  
               {
                 return $this->apiResponse($helprequest,'ok',200);
               }    
            
            else
            {
                 return response()->json([
                    'message' => 'No Data Found',
                    'data' => ''
                ], 404);
            }
           
            
           
        }
        else
        {
            return response()->json([
                    'message' => 'userf not Found',
                    'data' => ''
                ], 404);
        }
        
            }
            
        }
      
         elseif($guardkey=='tourguide_1')
        {
          $user=TourGuide::where('id',$userid)->first();
           $user_id=$user->id;
           if(HelpRequest::where('help_requests.tourguide_id',$user_id)->exists())
            {
                 $data['helprequests']=HelpRequest::select('help_requests.*',"helps.name->$lang as 'help_name'")
            ->where('help_requests.tourguide_id',$user_id)
            ->join('helps','help_requests.help_id', '=', 'helps.id')
            ->get();
    
            $helprequest=array();
            $HostName=request()->getHttpHost();
            if($data['helprequests']->count()>0)
            {
               foreach($data['helprequests'] as $data)
               {
                  $array['id']=$data->id;
                  $array['ticket_num']=$data->ticket_num;
                  $array['user_id']=$data->tourguide_id;
                  $array['help_id']=$data->help_id;
                  $array['request_details']=$data->request_details;
                  $array['status']=$data->status;
                  if($data->status !=='pending')
                  {
                    $array['admin_reply']=$data->admin_reply;
                  }
                  $array['created_at']=$data->created_at;
                  $array['updated_at']=$data->updated_at;
                  if(!is_null($data->request_photo))
                  {
                    $array['photo']="$HostName/public/assets/uploads/HelpRequests/TourguidesHelpRequest/".$data->request_photo;
                  }
                  array_push($helprequest,$array);
               }
           
             //paginate
               if(!empty($helprequest))  
               {
                 return $this->apiResponse($helprequest,'ok',200);
               }    
               else{
                 return $this->apiResponse("",'no help request found',200);
     
               }  
            //paginate
    
            }
            
            else
            {
                 return response()->json([
                    'message' => 'No Data Found',
                    'data' => ''
                ], 404);
            }
           
            
           
        }
            
        }
        
        

       
            
        
            
        
        
     ///
}


}
