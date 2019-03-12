<?php

namespace App\Services;

use App\Models\Industry;

class IndustryService
{

    /**
     * recreate industry array
     *
     * @return array
     */
    public function formatIndustryArr($industryArray): array
    {
    	$industry = array();

        if($industryArray['parent_id'] == 0) {
            $industry['data']['industry']['id'] = $industryArray['id'];
            $industry['data']['industry']['display_name'] = $industryArray['display_name'];
        } else {
            $parentIndustry = Industry::find($industryArray['parent_id']);
            $industry['data']['industry']['id'] = $parentIndustry['id'];
            $industry['data']['industry']['display_name'] = $parentIndustry['display_name'];              
            $industry['data']['sub']['id'] = $industryArray['id'];
            $industry['data']['sub']['display_name'] = $industryArray['display_name'];                
        }

        return $industry;
    }
    
}
