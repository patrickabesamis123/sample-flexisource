<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateWhitelistedCompaniesInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CandidateWhitelistedCompaniesInterface extends PrettusInterface
{
    public function getWhitelistedCompanies($request);
    public function getRequestedWhitelistCompanies($request);
    public function storeWhitelistedCompanies($request);
    public function allowWhitelistCompany($request);
    public function declineWhitelistCompany($request);
}
