<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{
    public function transform($company)
    {
        return [
            'id' => $company->id,
            'company_name' => $company->company_name,
            'company_logo_url' => $company->logo_url,
            'company_about_us' => $company->company_description,
            'company_url' => $company->company_url,
            'company_video_url' => $company->doc_video ? $company->doc_video->doc_url : '',
            'display_date' => date_format(date_create($company->publishing_date),"D d, M"),
            'location' => $company->location->toArray(),
        ];
    }
}