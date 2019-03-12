<?php

namespace App\Services;

use App\Repositories\Contracts\JobInterface;
use App\Repositories\Contracts\CompanyInterface;
use App\Models\Job;
use App\Models\Company;
use App\Criteria\WithCompanyJobmetaCriteria;
use App\Criteria\WithLocationCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchService
{
    private $job;
    private $company;

    /**
     * Constructor setup
     *
     * @param JobInterface $job
     * @param CompanyInterface $company
     */
    public function __construct(JobInterface $job, CompanyInterface $company)
    {
        $this->job     = $job;
        $this->company = $company;
    }

    /**
     * Fetches the active jobs
     *
     * @param array $search
     * @return void
     */
    public function getJobs(array $search = [])
    {
        /*$this->job->pushCriteria(new WithCompanyJobmetaCriteria('j_job.company_id', 'j_job.id'));

        $cols = [
            'object_id', 'job_title', 'company_name', 'logo_url as company_logo_url', DB::raw("CONCAT('job/job_listing/','object_id') AS job_url"), 'j_job_meta.meta_value', 'published_date as display_date', 'salary_type as salary_notes', 'j_job.industry_id', 'job_description', 'role_type_id'
        ];

        return $this->job->findWhere(array("job_status" => "active"), $cols);*/
        return $this->job->filterJobs($search);
    }

    /**
     * Fetches the active jobs
     *
     * @param array $search
     * @return void
     */
    public function getCompanies(array $search = [])
    {
        /*$this->company->pushCriteria(new WithLocationCriteria('e_company.location_id'));
        $cols = [
            'e_company.id', 'company_name', 'logo_url', 'company_description', 'location.id AS location_id', 'location.display_name AS location_display_name', 'company_url'
        ];
        $company_list = $this->company
                        ->findWhere(array("status" => "active"), $cols);

        return $company_list;*/
        
        return $this->company->filterCompanies($search);
    }
}
