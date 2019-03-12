<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\LocationInterface;
use App\Models\Location;
use App\Models\Country;
use App\Validators\LocationValidator;
use App\Criteria\WithCountryCriteria;
use DB;

/**
 * Class LocationRepository.
 *
 * @package namespace App\Repositories;
 */
class LocationRepository extends BaseRepository implements LocationInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Location::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * This fetches and formats location data for search display
     *
     * @return object
     */
    public function fetchLocationForSearchDisplay()
    {
        $this->pushCriteria(new WithCountryCriteria('location.country_id'));
        $userInput = Location::USER_INPUT;

        $cols = [
            'location.id', 'location.display_name',
            DB::raw("CASE WHEN location.parent_id IS NULL OR (location.type ='location' AND country.codeSlugName = 'nz') 
                          THEN 'All'
                          ELSE (SELECT p.display_name
                                FROM location p WHERE p.id = `location`.`parent_id` 
                                AND p.type != '$userInput') 
                    END as parent_name")
        ];

        $locationWithoutState = $this->scopeQuery(function ($query) {
            return $query->where('location.admin_approved', 1)
                ->whereIn('location.type', [Location::LOCATION, Location::AREA, Location::SUBURB]);
        })->get($cols);


        $this->resetScope();

        // to remove duplicate state of New Zealand
        $locationWithState = $this->scopeQuery(function ($query) {
            return $query->where('location.admin_approved', 1)
                ->where('location.type', Location::STATE)
                ->where('country.codeSlugName', '!=', Country::NZ);
        })->get($cols);

        return $locationWithoutState->concat($locationWithState);
    }

    /**
     * Use for search of location by country id.
     *
     * @return string
     */
    public function searchForLocationByCountry($slug_code)
    {
        $country = Country::select('id')->where('codeSlugName', $slug_code)->first();
        $query = Location::where('country_id', $country->id)
                    ->groupBy('display_name', 'slug_name')
                    ->get()
                    ->toArray();

        return $query;
    }

    /**
     * Use for autocomplete search of location
     *
     * @return string
     */
    public function searchForAutoComplete($data, $countryId)
    {
        $query = Location::select('display_name', 'slug_name')
                    ->where('country_id', $countryId)
                    ->where('display_name', 'like', '%' . $data . '%')
                    ->groupBy('display_name', 'slug_name')
                    ->get()
                    ->toArray();

        return $query;
    }

    /**
     * Use for autocomplete search of location for search
     *
     * @return string
     */
    public function searchForAutoCompleteSearch($data)
    {
        $query = Location::select('display_name', 'slug_name', 'id')
                    ->where('display_name', 'like', '%' . $data . '%')
                    ->where('admin_approved', 1)
                    ->groupBy('display_name', 'slug_name')
                    ->get()
                    ->toArray();

        return $query;
    }
}
