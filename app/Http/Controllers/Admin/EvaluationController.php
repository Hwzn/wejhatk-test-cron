<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StarRate;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function Tripagents_Evaluation()
    {
        $data['star_rate']=StarRate::where('to_tripagentid','!=',null)
                          ->select('trip_agents.name','star_rates.id','star_rates.from_userid','star_rates.to_tripagentid','star_rates.stars_rated'
                              ,'users.name as username','users.photo','star_rates.updated_at','star_rates.created_at')
                          ->join('trip_agents','trip_agents.id','=','star_rates.to_tripagentid')
                          ->join('users','users.id','=','star_rates.from_userid')
                         ->orderby('id','desc')
                         ->get();
          //  return response($data);
      return view('dashboard.admin.Evaluations.tripagent_evaluation')->with($data);
    }
    public function Tourguides_Evaluation()
    {
        $data['star_rate']=StarRate::where('to_tourguideid','!=',null)
                          ->select('tour_guides.name','star_rates.id','star_rates.from_userid','star_rates.to_tourguideid','star_rates.stars_rated'
                              ,'users.name as username','users.photo','star_rates.updated_at','star_rates.created_at')
                          ->join('tour_guides','tour_guides.id','=','star_rates.to_tourguideid')
                          ->join('users','users.id','=','star_rates.from_userid')
                         ->orderby('id','desc')
                         ->get();
          //  return response($data);
      return view('dashboard.admin.Evaluations.tourguide_evaluation')->with($data);
    }
}
