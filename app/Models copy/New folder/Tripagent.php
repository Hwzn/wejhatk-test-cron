<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tripagent extends Model
{
    use HasFactory;
    protected $table='trip_agents';
    protected $guarded=['id'];
}
