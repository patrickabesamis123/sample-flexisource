<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;

class JobTransformer extends TransformerAbstract
{
    public function transform($job)
    {
        return [
            'object_id' => $job->object_id,
            'job_title' => $job->job_title,
            'company_name' => $job->company->company_name,
            'company_logo_url' => $job->company->logo_url,
            'location' => ['id' => $job->location->id, 'display_name' => $job->location->display_name, 'user_input' => $job->location->admin_approved],
            'job_url' => '/job/listing/' . $job->object_id,
            'job_video_url' => (count($job->job_meta_video_url) > 0) ? $job->job_meta_video_url[0]['meta_value'] : '',
            'display_date' => date_format(date_create($job->publishing_date),"D d, M"),
            'salary_notes' => $job->salary_notes,
            'industry' => $job->industry->industry_id,
            'description' => $job->job_description,
            'role_type' => $job->role_type->displayName
        ];
    }
}