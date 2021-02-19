<?php

namespace Fennecio\SearchInModel\Actions\Search;

use Fennecio\SearchInModel\Exceptions\SearchException;
use Fennecio\SearchInModel\Traits\collection\CollectionHelpers;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;


class SearchInModel {

    use CollectionHelpers;

    protected $conditions;
    
    
    public function __construct($conditions)
    {   
        
        $this->conditions = $conditions;
        
    }




    public const SEARCH_INDEXES = [
        'columns' => 'is_array',
        'with' => 'is_array',
        'relations' => 'is_array',
    ];

    public const SEARCH_INDEXES_WHEREIN = [
        'name' => 'is_string',
        'table' => 'is_string',
        'values' => 'is_array',
        'key' => 'is_string',
        'query' => 'is_string'
    ];


    public const SEARCH_INDEXES_WHERE = [
        'name' => 'is_string',
        'table' => 'is_string',
        'query' => 'is_string',
        'columns' => 'is_array'
    ];






    public function search($model)
    {

        $check = $this->checkArrayAttributes($this->conditions, self::SEARCH_INDEXES);

        if (!$check) throw new SearchException();

        $columns_index = array_keys(self::SEARCH_INDEXES);


        foreach ($columns_index as  $value) {
            
            if (Arr::has($this->conditions, $value)) {
                
                $conditions_to_apply = $this->conditions[$value];
                $model = call_user_func([$this, 'apply_' . $value], $conditions_to_apply,$model);
            }
        }


        return $model;

    }

    public function apply_relations($relations,$model)
    {
        foreach ($relations as  $value) {

            $check_where_in = $this->checkArrayAttributes($value, self::SEARCH_INDEXES_WHEREIN);
            $check_where = $this->checkArrayAttributes($value, self::SEARCH_INDEXES_WHERE);

            if (!$check_where && !$check_where_in) throw new SearchException();
            
            if (method_exists($model, $value['name'])){
                // type of return is builder make sure you didn't affect the original value of the $model
                $model->whereHas($value['name'], function ($q) use ($value) {
                    $table = $value['table'];

                    // where in array 
                    if ($value['query'] === 'whereIn')
                        $q->whereIn($table . '.' . $value['key'], $value['values']);
                    // where column 
                    if ($value['query'] === 'where') {
                        $whereColumns = $value["columns"];
                        /**
                         * ["key","op","value"]
                         */
                        $q->where($whereColumns);
                    }
                });
            }
        }

        return $model;
    }


    public function apply_with($with,$model)
    {

        foreach ($with as $value) {
            try {
                
                // check if this relation does exist 
                $model->getRelation($value);
                // type of return is builder make sure you didn't affect the original value of the $model
                $model->with([$value]);

            } catch (Exception $e) {

                if (method_exists($model, $value))
                    $model->with([$value]);
                // if not go to the next relation
                continue;
            }

        }

        return $model;
    }

    public function apply_columns($columns,$model)
    {   
        
        foreach ($columns as $value) {
            // check if column exist in model table
            if (Schema::hasColumn($model->getTable(),head($value)))
                // in case of where you must get the new model instance 
                $model = $model->where([$value]);
        }

        return $model;
    }

    
}