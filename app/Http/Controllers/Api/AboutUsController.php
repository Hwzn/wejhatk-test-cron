<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index($lang)
    {
        $abouts=AboutUs::select('id',"desc->$lang as 'desc_name'")->get();

        if($abouts)
        {
            return response()->json([
                'message' => 'ok',
                'data' => $abouts
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
