<?php

namespace App\Repositories\Contracts;

/**
 * Interface PMUserInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface PMUserInterface
{
    public function checkIdExist($id);
    public function getDetails($id);
    public function updateName($data, $id);
}
