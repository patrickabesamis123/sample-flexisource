<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateBlacklistedCompaniesInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CandidateBlacklistedCompaniesInterface extends PrettusInterface
{
    public function getBlacklistedCompanies($request);
    public function storeBlacklistedCompanies($request);
}
