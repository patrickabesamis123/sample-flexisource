<?php

namespace App\Services;

use App\Models\Location;
use App\Models\Country;

class LocationService
{
    /**
     * recreate preferred location array
     *
     * @return array
     */
    public function formatPreferredLocationArr($locArray): array
    {
        $location = array();

        $location['data']['slug_name'] = $locArray['slug_name'];
        $location['data']['type'] = $locArray['type'];

        $parentLocation = Location::find($locArray['parent_id']);
        $location['data']['id'] = $locArray['id'];
        $location['data']['display_name'] = "".$locArray['display_name'].", ".$parentLocation['display_name']."";
            
        $country = Country::find($locArray['country_id']);
        $location['data']['country']['id'] = $locArray['country_id'];
        $location['data']['country']['display_name'] = $country['displayName'];
        $location['data']['country']['short_name'] = $country['codeDisplayName'];

        return $location;
    }

}
