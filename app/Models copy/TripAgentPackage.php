<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripAgentPackage extends Model
{
    use HasFactory;
    protected $table='tripagent_packages';

    protected $guarded=['id'];
}
