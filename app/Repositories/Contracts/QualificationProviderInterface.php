<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface QualificationProviderInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface QualificationProviderInterface extends PrettusInterface
{
    public function search($displayName, $limit);
    public function list();
}
