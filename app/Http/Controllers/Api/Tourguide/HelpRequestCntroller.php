<?php

namespace App\Http\Controllers\Api\Tourguide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpRequest;
use App\Models\Help;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Support\Collection;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
class HelpRequestCntroller extends Controller
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
        $helpimage=null;
        $rand_num=mt_rand(100000000,999999999);
        $validator = Validator::make($request->all(), [
            'help_id' => 'required|exists:helps,id',
            'tourguide_id' => 'required|exists:tour_guides,id',
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
                  $file->move('assets/uploads/HelpRequests/TourguidesHelpRequest',$filename);
                  $helpimage=$filename;

             }
         
             $user=HelpRequest::create([
                 'ticket_num'=>'#'.$rand_num,
                 'tourguide_id'=>$request->tourguide_id,
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

    public function showhelprequests($lang)
    {
       
       $tourguide_id=Auth::user()->id;
        if(HelpRequest::where('help_requests.tourguide_id',$tourguide_id)->exists())
        {
             $data['helprequests']=HelpRequest::select('help_requests.*',"helps.name->$lang as 'help_name'")
        ->where('help_requests.tourguide_id',$tourguide_id)
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
              $array['tourguide_id']=$data->tourguide_id;
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
}
