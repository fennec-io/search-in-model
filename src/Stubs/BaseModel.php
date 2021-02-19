<?php

namespace App\Models;

use App\Criteria\Search\SearchCriteria;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    

    public const MODELS = [
        'doctor' => Doctor::class,
        'clinic' => Clinic::class
    ];




    public static function Model($model){

        return app()[self::MODELS[$model]];

    }



    public function repository($criteria=null){

        $repo = app()[$this->repository];
        
        if($criteria)
        $repo->pushCriteria(new SearchCriteria($criteria));
        return $repo;
    }
}