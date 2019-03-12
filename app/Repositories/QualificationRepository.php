<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\QualificationInterface;
use App\Models\Qualification;

/**
 * Class QualificationRepository.
 *
 * @package namespace App\Repositories;
 */
class QualificationRepository extends BaseRepository implements QualificationInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Qualification::class;
    }

    /**
     * Search Qualification on DB
     */
    public function search($displayName, $limit)
    {
        $query = Qualification::select('display_name')
                    ->where('display_name', 'like', '%' . $displayName . '%')
                    //->where('is_admin_approved', 1)
                    ->groupBy('display_name')
                    ->limit($limit)
                    ->get()
                    ->toArray();

        return $query;
    }

    /**
     * Display all qualification list
     *
     * @return string
     */
    public function list()
    {
        $query = Qualification::select('display_name')
                    ->groupBy('display_name')
                    ->get()
                    ->toArray();

        return $query;
    }

}
