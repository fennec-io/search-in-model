<?php

namespace App\Traits\collection;

use Illuminate\Support\Collection;

trait CollectionHelpers {




    public function mergeQueryCollections($key,$parent,$sub,$sub_name){

            $result = new Collection();

            foreach ($parent as $value) {
              
              $sub_res = $value->toArray();

              $second_filter = $sub->where($key.'_id',$value->id);

              $sub_res[$sub_name] = $second_filter;

              $result->add($sub_res);
        }

        return $result;
    }


    public function checkArrayAttributes($inputs,$conditions){

        if(empty($inputs)) return false;
        

        foreach ($inputs as $key => $value) {
            if (!(array_key_exists($key,$conditions) && call_user_func($conditions[$key], $value))) {
                return false;
            }
        }


        return true;
    }
}