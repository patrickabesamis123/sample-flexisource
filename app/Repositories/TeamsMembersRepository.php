<?php

namespace App\Repositories;

use App\Repositories\Contracts\TeamsMembersInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\TeamsMembers;

/**
 * Interface WorkTypeRepository.
 *
 * @package namespace App\Repositories;
 */
class TeamsMembersRepository extends BaseRepository implements TeamsMembersInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TeamsMembers::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
