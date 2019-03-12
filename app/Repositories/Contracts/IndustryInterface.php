<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface IndustryRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface IndustryInterface extends RepositoryInterface
{
    public function fetchIndustriesAndSubIndustries();
    public function listParent();
    public function listParentAndSub();
}
