<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface JobInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface JobMetaInterface
{
	public function getRequirementsCheck($jobId, $candidateId);
	public function candidateHas($candidateId, $requirement);
}
