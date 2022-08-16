<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function trip_agent()
    {
        return $this->belongsTo('App\Models\Tripagent','tripagent_id');
    }

    // public function tour_guide()
    // {
    //     return $this->belongsTo('App\Models\TourGuide','tourguide_id');
    // }
    
}
