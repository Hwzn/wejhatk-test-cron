<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class RetrunPloicy extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded=['id'];
    protected $table='retrun_ploicies';

    public $translatable = ['name'];
  public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
}
