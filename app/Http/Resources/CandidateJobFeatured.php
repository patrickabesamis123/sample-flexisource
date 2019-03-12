<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Location;

class CandidateJobFeatured extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $location = $this->location_type === Location::USER_INPUT
            ? $this->location
            : $this->country . ', ' . $this->location;
        return [
            'company' => [
                'name' => $this->company_name,
                'banner_url' => $this->company_banner_url,
                'logo_url' => $this->logo_url,
                'url' => $this->company_url,
            ],
            'job' => [
                'id' => $this->id,
                'object_id' => $this->object_id,
                'title' => $this->job_title,
                'watchlist' => $this->watchlist
            ],
            'location' => $this->location
        ];
    }
}
