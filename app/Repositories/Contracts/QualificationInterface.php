<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface QualificationInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface QualificationInterface extends PrettusInterface
{
    public function search($displayName, $limit);
    public function list();
}
