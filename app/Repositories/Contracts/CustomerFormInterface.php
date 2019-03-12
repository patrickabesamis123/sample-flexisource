<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface CustomerFormInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CustomerFormInterface extends PrettusInterface
{
    public function storeContactUs($request);
    public function storeHarmfulComplaint($request);
}
