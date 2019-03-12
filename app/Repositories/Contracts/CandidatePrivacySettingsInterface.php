<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidatePrivacySettingsInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CandidatePrivacySettingsInterface extends PrettusInterface
{
    public function getSettings($request);
    public function updateSettings($request);
}
