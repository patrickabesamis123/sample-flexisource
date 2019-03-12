<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Location;

class CandidateCompanySuggestion extends JsonResource
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
                'id' => $this->id,
                'ob_key' => $this->ob_key,
                'name' => $this->company_name,
                'logo_url' => $this->logo_url,
                'url' => $this->company_url,
                'banner_url' => $this->company_banner_url,
                'video_url' => $this->video_url
            ],
            'industry' => $this->industry,
            'location' => $this->location,
        ];
    }
}
