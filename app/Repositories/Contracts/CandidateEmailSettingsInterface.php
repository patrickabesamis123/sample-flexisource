<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateEmailSettingsInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CandidateEmailSettingsInterface extends PrettusInterface
{   
    public function getSettings($request);
    public function updateSettings($request);
}
