<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface EmployerInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface EmployerInterface extends PrettusInterface
{
    public function getEmployerId($user_id);
    public function getOpenRoles($employer_id);
    public function getClosedJobs($employer_id);
    public function getDraftJobs($employer_id);
    public function getWatchlist($employer_id);
    public function getInfoById(string $employer_id);
    public function updateEmail($request);
    public function updatePassword($request);
    public function updateBasicInfo($request);
    public function updateAccountType($request);
    public function updateAccountStatus($request);
    public function storeJsIntegrationRequest($request);
    public function getJsIntegrationStatus($request);
    public function getPermissions($request);
}
