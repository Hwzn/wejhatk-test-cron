<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SelectType extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded=['id'];
    protected $hidden=['pivot'];

    protected $table='select_types';
    public $translatable = ['name'];
    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function Services()
    {
        return $this->belongsToMany('App\Models\Serivce','selecttype_service','selecttype_id','service_id');
    }
}
