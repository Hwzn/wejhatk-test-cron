<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $auth_id=Auth::id();
        $data['settings']=Admin::where('id',$auth_id)->first();
        return view('dashboard.admin.settings.index')->with($data);
    }

    public function store(Request $request)
    {
        $user=Auth::user();

        $data = Validator::make($request->all(), [
             'name' => 'required|string|max:255|',
             'phone' => 'required|string|unique:users,phone,'.$user->id,
             'password'=> ['required','string','min:3'],
             'password_confirm'=>'required|same:password|string|min:3',
        ]);
        if($data->fails()){
            return response()->json($data->errors()->toJson(), 400);
        }
        try{
            $user=Admin::findorfail($user->id)->update([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'password'=>bcrypt($request->password),
            ]);
    
            return response()->json([
                        'message' => 'User successfully Updated',
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
    
}
