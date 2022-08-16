<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAttruibute extends Model
{
    use HasFactory;
    protected $table='service_attribute';
    protected $guarded=['id'];

    public function services()
    {
        return $this->belongsTo('App\Models\Serivce','service_id');

    }

    public function attributes()
    {
        return $this->belongsTo('App\Models\Attribute','attribute_id');
        
    }
}
