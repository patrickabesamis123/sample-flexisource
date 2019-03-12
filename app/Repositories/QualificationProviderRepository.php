<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\QualificationProviderInterface;
use App\Models\QualificationProvider;

/**
 * Class QualificationProviderRepository.
 *
 * @package namespace App\Repositories;
 */
class QualificationProviderRepository extends BaseRepository implements QualificationProviderInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return QualificationProvider::class;
    }

    /**
     * Search QualificationProvider on DB
     */
    public function search($displayName, $limit)
    {
        $query = QualificationProvider::select('provider_display_name')
                    ->where('provider_display_name', 'like', '%' . $displayName . '%')
                    //->where('isAdminApproved', 1)
                    ->groupBy('provider_display_name')
                    ->limit($limit)
                    ->get()
                    ->toArray();

        return $query;
    }

    /**
     * Display all qualification provider list
     *
     * @return string
     */
    public function list()
    {
        $query = QualificationProvider::select('provider_display_name')
                    ->groupBy('provider_display_name')
                    ->get()
                    ->toArray();

        return $query;
    }

}
