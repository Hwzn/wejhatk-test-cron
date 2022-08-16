<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommonQuestion;
use Illuminate\Http\Request;

class CommonQuestions extends Controller
{
    public function index($lang)
    {
        $commonQuestion=CommonQuestion::select('id',"question->$lang as 'Question'","answer->$lang as 'Answer")
          ->paginate(7);

        if($commonQuestion)
        {
            return response()->json([
              'message'=>'odddk',
              'data'=>$commonQuestion,
            ],200);
        }
        else{
            return response()->json([
                'message' => 'Error in return data',
                'data' => ''
            ], 405);
        }
    }
}
