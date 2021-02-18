<?php

namespace Fennecio\SearchInModel\Traits\controller\Search;

use Fennecio\SearchInModel\Models\BaseModel;
use Inertia\Inertia;

trait HasSearch {


    
    public function search($request,$comp){
        
        $result_type = $request->result_type;

        $repository = BaseModel::Model($result_type)->repository();

        $repository->search($request->q);

        return Inertia::render($comp,[
            'data' => [
                $request->result_type => $repository->all()
            ]
        ]);
    }


}