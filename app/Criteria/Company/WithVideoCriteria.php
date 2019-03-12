<?php

namespace App\Criteria\Company;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithVideoCriteria.
 *
 * @package namespace App\Criteria\Company;
 */
class WithVideoCriteria implements CriteriaInterface
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
        return $model->leftJoin('e_docs', 'e_docs.id', 'e_company.company_video_id');
    }
}
