<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarRate extends Model
{
    use HasFactory;
    protected $table='star_rates';
    protected $guarded=['id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','from_userid');
    }

    public function tripagent()
    {
        return $this->belongsTo('App\Models\Tripagent','to_tripagentid');
    }
    public function tourguide()
    {
        return $this->belongsTo('App\Models\TourGuide','to_tourguideid');
    }
}
