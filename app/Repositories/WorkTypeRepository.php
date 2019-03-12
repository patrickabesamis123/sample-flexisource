<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\WorkTypeInterface;
use App\Models\WorkType;
use App\Validators\WorkTypeValidator;

/**
 * Class WorkTypeRepository.
 *
 * @package namespace App\Repositories;
 */
class WorkTypeRepository extends BaseRepository implements WorkTypeInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkType::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Display all work type
     *
     * @return string
     */
    public function list()
    {
        $query = WorkType::select('id', 
                                  'displayName AS display_name')
                        ->get();

        return $query;
    }
}
