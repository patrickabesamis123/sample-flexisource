<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Contracts\CompanyFollowerInterface;

use App\Models\CompanyFollower;

/**
 * Class CompanyFollowerRepository.
 *
 * @package namespace App\Repositories;
 */
class CompanyFollowerRepository extends BaseRepository implements CompanyFollowerInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CompanyFollower::class;
    }

}
