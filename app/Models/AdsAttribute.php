<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class AdsAttribute extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='ads_attributes';

    use HasTranslations;
    public $translatable = ['name'];

    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
    
    public function attr_type()
    {
        return $this->belongsTo('App\Models\AttributeType','attr_typeid');
    }

}
