<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaviourtTripAgent extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='faviourt_tripagents';

    public function tripagent()
    {
        return $this->belongsTo('App\Models\Tripagent','TripAgent_id');
    }
}
