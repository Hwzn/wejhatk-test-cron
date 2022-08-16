<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripagentStatistic extends Model
{
    use HasFactory;

    protected $table='tripagent_statistics';
    protected $guarded=['id'];
}
