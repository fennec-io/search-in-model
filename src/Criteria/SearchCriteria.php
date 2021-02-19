<?php

namespace Fennecio\SearchInModel\Criteria\Search;

use App\Actions\Search\SearchInModel;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SearchCriteria.
 *
 * @package namespace App\Criteria\Search;
 */
class SearchCriteria implements CriteriaInterface
{
    

    protected $conditions;
    protected $searchInModel;
    
    
    public function __construct($conditions)
    {
        $this->conditions = $conditions;
        $this->searchInModel = new SearchInModel($conditions);
        
    }
    /**
     * Apply criteria in query repository
     *
     * @param Model              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $this->searchInModel->search($model);

        return $model;
    }


    
}
