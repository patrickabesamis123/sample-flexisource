<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
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
            'company_name' => $this->company_name,
            'status' => $this->status,
            'num_of_employees' => $this->num_of_employees,
            'logo_url' => $this->logo_url,
            "website_url" => $this->website_url,
            "company_phone" => $this->company_phone,
            "company_fax" => $this->company_fax,
            "industry" => [],
            "street_address" => $this->street_address,
            "street_address_2" => $this->street_address_2,
            "location" => [],
            "nz_business_num" => $this->nz_business_num,
            "company_url" => $this->company_url,
            "company_banner_url" => $this->company_banner_url,
            "company_description" => $this->company_description,
            "company_video" => [],
            "company_branch_locations" => $this->company_branch_locations,
            "helper_text" => $this->helper_text
        ];
    }
}
