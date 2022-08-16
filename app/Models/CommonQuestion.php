<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class CommonQuestion extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='common_questions';

    use HasTranslations;
    public $translatable = ['question','answer'];
    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
}
