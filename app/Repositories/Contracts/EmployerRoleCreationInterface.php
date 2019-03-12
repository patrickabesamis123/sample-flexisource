<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface EmployerRoleCreationInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface EmployerRoleCreationInterface extends PrettusInterface
{
    public function drafts($company_id, $request);
    public function classifications($company_id, $request);
    public function search($company_id, $request);
    public function preview($company_id, $template_id);
}
