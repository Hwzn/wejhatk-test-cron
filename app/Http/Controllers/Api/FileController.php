<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function uploadfiles(Request $request)
    {
       // return response('dddd');
        $validator = Validator::make($request->all(), [
            'file'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            DB::beginTransaction();
     
            $urlhost=request()->getHttpHost();

            if($request->hasfile('file')) 
             {
               
                $rand_num=mt_rand(100000000,999999999);
                $file=$request->file('file');
                  $ext=$file->getClientOriginalExtension();
                  $filename=$rand_num.'.'.$ext;
                  $file->move("assets/uploads/files/",$filename);
                  $file=$filename;

             }
         
     
             DB::commit();
             return response()->json([
                         'message' => 'File Uploads  Successfully',
                         'user' => "$urlhost/assets/uploads/files/$file",
                     ], 200);
                         
         
         }
         catch(\Exception $ex){
             DB::rollBack();
             return response()->json([
                 'message' => $ex,
                 'user' => 'Error in Upload File'
             ], 404);
         }
    }
}
