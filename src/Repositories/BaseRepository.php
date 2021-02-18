<?php

namespace App\Repositories;

use Fennecio\SearchInModel\Exceptions\SearchException;
use Fennecio\SearchInModel\Traits\collection\CollectionHelpers;
use ErrorException;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

abstract class BaseRepository extends EloquentBaseRepository
{
    use CollectionHelpers;

    public const SEARCH_INDEXES = [
        'relations' => 'is_array',
        'columns' => 'is_array',
        'with' => 'is_array'
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






    public function search($conditions)
    {
        $check = $this->checkArrayAttributes($conditions, self::SEARCH_INDEXES);

        if (!$check) throw new SearchException();

        $columns_index = array_keys(self::SEARCH_INDEXES);

        foreach ($columns_index as  $value) {

            if (Arr::has($conditions, $value)) {
                $conditions_to_apply = $conditions[$value];
                call_user_func([$this, 'apply_' . $value], $conditions_to_apply);
            }
        }
    }

    public function apply_relations($relations)
    {

        foreach ($relations as  $value) {

            $check_where_in = $this->checkArrayAttributes($value, self::SEARCH_INDEXES_WHEREIN);
            $check_where = $this->checkArrayAttributes($value, self::SEARCH_INDEXES_WHERE);

            if (!$check_where && !$check_where_in) throw new SearchException();

            if (method_exists($this->getModel(), $value['name']))
                $this->whereHas($value['name'], function ($q) use ($value) {

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


    public function apply_with($with)
    {

        foreach ($with as $value) {

            try {

                // check if this relation does exist 
                $this->getModel()->getRelation($value);

                $this->with([$value]);

            } catch (Exception $e) {   
                
                if (method_exists($this->getModel(), $value))
                    $this->with([$value]);

                // if not go to the next relation
                continue;
            }

        }
    }

    public function apply_columns($columns)
    {   
        foreach ($columns as $value) {
            // check if column exist in model table
            if (Schema::hasColumn($this->getModel()->getTable(), head($value)))
            $this->findWhere([$value]);
        }
    }
}
