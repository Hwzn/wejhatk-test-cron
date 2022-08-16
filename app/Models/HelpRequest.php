<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpRequest extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='help_requests';

    public function helps()
    {
        return $this->belongsTo('App\Models\Help','help_id');
    }
    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function tripagents()
    {
        return $this->belongsTo('App\Models\Tripagent','tripagent_id');
    }

    public function tourguides()
    {
        return $this->belongsTo('App\Models\TourGuide','tourguide_id');
    }

}
