<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use Illuminate\Database\Eloquent\SoftDeletes;
class Serivce extends Model
{
    use SoftDeletes;
    
    use HasFactory;
    protected $guarded=['id'];

    use HasTranslations;
    public $translatable = ['name'];
   protected $hidden=['pivot'];
    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Models\Attribute','service_attribute','service_id','attribute_id');
    }

    public function Tripagents()
    {
      return $this->belongsToMany('App\Models\Tripagent','tripagent_service','service_id','tripagent_id');
    }

    public function select_types()
    {
        return $this->belongsToMany('App\Models\SelectType','selecttype_service','service_id','selecttype_id');
    }


}
