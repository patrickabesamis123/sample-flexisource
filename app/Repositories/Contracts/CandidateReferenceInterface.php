<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateReferenceInterface.
 *
 * @package namespace App\Repositories;
 */
interface CandidateReferenceInterface extends PrettusInterface
{
    public function createReference($data);
    public function updateReference($data, $referenceId);
    public function deleteReference($referenceId);
}
