<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CandidateNotificationSettingsInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CandidateNotificationSettingsInterface extends PrettusInterface
{
    public function getSettings($request);
    public function updateSettings($request);
}
