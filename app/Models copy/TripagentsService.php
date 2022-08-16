<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripagentsService extends Model
{
    use HasFactory;
    protected $table='tripagents_service';
    protected $guarded=['id'];

    public function Tripagents()
    {
      return $this->belongsToMany('App\Models\Tripagent','tripagent_id');
    }
}
