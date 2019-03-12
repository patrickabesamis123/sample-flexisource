<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Company;

class CandidateJobLog extends JsonResource
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
            'id' => $this->id,
            'company' => Company::find($this->company_id, ['company_name'])->company_name,
            'job' => $this->job,
            'created_at' => (new \DateTime($this->created_at))->format('m/d/y')
        ];
    }
}
