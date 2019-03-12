<?php

namespace App\Criteria\Candidate;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithDocsCriteria.
 *
 * @package namespace App\Criteria\Candidate;
 */
class WithDocsCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('c_docs', 'c_docs.candidate_id', 'candidate.id');
    }
}
