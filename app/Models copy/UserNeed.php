<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNeed extends Model
{
    use HasFactory;
    protected $table='user_needs';
    protected $guarded=['id'];
}
