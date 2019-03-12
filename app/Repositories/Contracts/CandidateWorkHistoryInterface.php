<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateWorkHistoryInterface.
 *
 * @package namespace App\Repositories;
 */
interface CandidateWorkHistoryInterface extends PrettusInterface
{
    public function createWorkHistory($data);
    public function updateWorkHistory($data, $workHistoryId);
    public function deleteWorkHistory($workHistoryId);
}
