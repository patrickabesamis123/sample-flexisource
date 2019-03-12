<?php

namespace App\Criteria\JobWorkflowStep;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithJobDefaultWorkflowStepCriteria.
 *
 * @package namespace App\Criteria\JobWorkflowStep;
 */
class WithJobDefaultWorkflowStepCriteria implements CriteriaInterface
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
            'j_default_workflow_step',
            'j_default_workflow_step.id',
            'j_job_workflow_step.original_workflow_step_id'
        );
    }
}
