<?php

namespace App\Criteria\JobApplication;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithJobWorkflowProgressCriteria.
 *
 * @package namespace App\Criteria\JobApplication;
 */
class WithJobWorkflowProgressCriteria implements CriteriaInterface
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
        return $model->leftJoin(
            'j_job_workflow_progress',
            'j_job_workflow_progress.application_id',
            'c_job_application.id'
        );
    }
}
