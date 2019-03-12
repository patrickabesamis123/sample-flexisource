<?php

namespace App\Criteria\Job;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Job;

/**
 * Class ActiveJobCriteria.
 *
 * @package namespace App\Criteria\Job;
 */
class ActiveJobCriteria implements CriteriaInterface
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
        return $model->where([
            ['job_status', Job::ACTIVE],
            ['expiry_date', '>', date('Y-m-d H:i:s')]
        ]);
    }
}
