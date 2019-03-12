<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CountryInterface;
use App\Models\Country;

/**
 * Class CountryRepository.
 *
 * @package namespace App\Repositories;
 */
class CountryRepository extends BaseRepository implements CountryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Country::class;
    }

    /**
     * Display all country list
     *
     * @return string
     */
    public function list()
    {
        $query = Country::select('id', 
                                'displayName AS display_name',
                                'slugName AS slug_name', 
                                'codeSlugName AS code_slug_name', 
                                'codeSlugName AS country_code')
                        ->get();

        return $query;
    }
}
