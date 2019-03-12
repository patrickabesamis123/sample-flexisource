<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WIthJobWorkflowStepCriteria.
 *
 * @package namespace App\Criteria;
 */
class WithJobWorkflowStepCriteria implements CriteriaInterface
{
   /**
     * Constructor setup
     *
     * @param [string] $foreignKeyAlias - foreign key to connect to jobs table
     */
    public function __construct(string $foreignKeyAlias)
    {
        $this->foreignKeyAlias = $foreignKeyAlias;
    }
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
        return $model->leftJoin('j_job_workflow_step', 'j_job_workflow_step.id', $this->foreignKeyAlias);
    }
}
