<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ConsultationType extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='consultation_types';
    use HasTranslations;
    public $translatable = ['name'];

    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
}
