<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OtherService extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='other_services';
    use HasTranslations;
    public $translatable = ['name'];

    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
}
