<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpRequest;
use App\Models\Help;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HelpRequestController extends Controller
{
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
                  $file->move('assets/uploads/UserHelpRequests',$filename);
                  $helpimage=$filename;
             }
         
             $user=HelpRequest::create([
                 'ticket_num'=>$rand_num,
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

    public function showhelprequests($lang,$user_id)
    {
        // $validator = Validator::make([
        //     'user_id' => 'required|exists:users,id',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        // $data=HelpRequest::where('user_id',$user_id)->orderby('id','desc')
        //   ->get();
        $data=HelpRequest::select('help_requests.*',"helps.name->$lang as 'help_name'")
        ->where('help_requests.user_id',$user_id)
        ->join('helps','help_requests.help_id', '=', 'helps.id')
        ->paginate(10);

      //  $profile=Client::select('clients.*','client_types.name as type_name','client_types.id')->where('clients.id',$id)->join('client_types','client_types.id','=','clients.client_type_id')->first();

        if($data)
        {
            return response()->json([
                'message' => 'ok',
                'data' => $data
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Error in return data',
                'data' => ''
            ], 405);
        }
    }

}
