<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface JobInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface JobInterface extends PrettusInterface
{
    public function checkOjectIdExist($objectId);
    public function getDetails($objectId);
    public function getJobSearchWidget($request);
    public function getApplicationDetails($candidateId, $jobObjectId);
    public function filterJob($field, $value);
    public function filterJobs(array $search = []);
}
