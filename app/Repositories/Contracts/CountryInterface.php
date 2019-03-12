<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CountryInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CountryInterface extends PrettusInterface
{
    public function list();
}
