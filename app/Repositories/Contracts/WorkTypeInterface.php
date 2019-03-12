<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface WorkTypeInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface WorkTypeInterface extends PrettusInterface
{
    public function list();
}
