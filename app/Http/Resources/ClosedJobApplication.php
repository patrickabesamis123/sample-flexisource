<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClosedJobApplication extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'job' => [
                'job_title' => $this->job_title,
                'object_id' => $this->object_id
            ],
            'company' => [
                'name' => $this->company_name,
                'url' => $this->company_url,
                'logo_url' => $this->logo_url
            ]
        ];
    }
}
