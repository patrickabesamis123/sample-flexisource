<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateJobApplicationInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CandidateJobApplicationInterface extends PrettusInterface
{
    public function getClosedJobApplication();
    public function getAppliedJobApplication();
    public function getJobApplicationByStatus($candidateId, $status);
    public function getSteps($jobObjId);
    public function completeApplication($objectId);
    public function postPreApplyQuestions($request, $jobObjId);
    public function calculateCompletionReturnResponse($applicationObjId);
    public function postRequirementsCheck($request, $jobObjId , $applicationObjId);
}
