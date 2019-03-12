<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CandidateInterface extends PrettusInterface
{
    public function updateByPMUserId($data, $pmUserId);
    public function show($request);
    public function updateEmailAddress($request);
    public function updatePassword($request);
    public function updateProfileUrl($request);
    public function updatePreferredLocation($request, $id);
}
