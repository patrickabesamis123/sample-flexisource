<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface IntegrationInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface IntegrationInterface extends PrettusInterface
{
    public function getJsIntegrationConfig($request);
    public function storeJsIntegrationConfig($request);
}
