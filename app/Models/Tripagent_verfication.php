<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tripagent_verfication extends Model
{
    use HasFactory;
    public $table='tripagent_verfications';
    protected $fillable=['user_id','otpcode','expired_at'];
}
