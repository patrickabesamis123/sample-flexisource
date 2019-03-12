<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CompanyInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CompanyInterface extends PrettusInterface
{
    public function getInfoByUrl(string $company_url);
    public function getInfoById(string $company_id);
    public function updateInfo($request);
    public function getEmployers(string $company_id);
    public function getTeams($request);
    public function getTeamMembers($request);
    public function storeTeam($request);
    public function updateTeam($request);
    public function destroyTeam($request);
    public function destroyTeamMember($request);
    public function storeInvitedTeamMember($request);
    public function filterCompanies(array $search = []);
}
