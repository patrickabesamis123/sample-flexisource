<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Job;
use App\Models\Company;

class CandidateJobWatchlist extends JsonResource
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
                'object_id' => $this->object_id,
                'expiry_date' => $this->expiry_date ? (new \DateTime($this->expiry_date))->format('l, d F, Y') : ''
            ],
            'company' => [
                'name' => $this->company_name,
                'company_url' => $this->company_url,
                'logo_url' => $this->logo_url
            ]
        ];
    }
}
