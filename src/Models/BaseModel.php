<?php

namespace Fennecio\SearchInModel\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    public const MODELS = [
        // 'doctor' => Doctor::class,
        // 'clinic' => Clinic::class
    ];




    public static function Model($model){

        return app()[self::MODELS[$model]];

    }



    public function repository(){
        return app()[$this->repository];
    }
}