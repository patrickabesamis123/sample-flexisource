<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateWorkHistoryInterface.
 *
 * @package namespace App\Repositories;
 */
interface CandidateQualificationInterface extends PrettusInterface
{
    public function createQualification($data);
    public function updateQualification($data, $qualificationId);
    public function deleteQualification($qualificationId);
}
