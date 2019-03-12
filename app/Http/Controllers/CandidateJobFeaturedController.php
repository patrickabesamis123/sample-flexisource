<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CandidateJobFeatured;

use App\Models\Candidate;
use App\Criteria\Job\ActiveJobCriteria;
use App\Repositories\Contracts\JobInterface;
use App\Criteria\WithCompanyCriteria;
use App\Criteria\WithLocationCriteria;
use App\Criteria\WithCountryCriteria;
use DB;

class CandidateJobFeaturedController extends Controller
{
    private $repository;

    public function __construct(JobInterface $repository)
    {
        $this->repository = $repository;
    }
   
    public function __invoke()
    {
        $this->repository->pushCriteria(ActiveJobCriteria::class)
            ->pushCriteria(new WithCompanyCriteria('j_job.company_id'))
            ->pushCriteria(new WithLocationCriteria('e_company.location_id'))
            ->pushCriteria(new WithCountryCriteria('location.country_id'));

        $cols = [
            'e_company.company_banner_url',
            'e_company.logo_url',
            'e_company.company_url',
            'e_company.company_name',
            'j_job.id',
            'j_job.object_id',
            'j_job.job_title',
            'location.display_name as location',
            'location.type as location_type',
            'country.displayName as country',
            DB::raw('IF(c_job_watchlist.candidate_id IS NULL, FALSE, TRUE) as watchlist')
        ];

        $featuredJobs = $this->repository->scopeQuery(function ($query) {
            $candidateJobApplications = Candidate::find(3)->jobApplications->pluck('job_id');
            return $query->leftJoin('c_job_watchlist', function ($jobWatchlist) {
                $candidate = Candidate::latest()->first();
                $jobWatchlist->on('c_job_watchlist.job_id', '=', 'j_job.id')
                    ->where('c_job_watchlist.candidate_id', '=', $candidate->id);
            })->whereNotIn('j_job.id', $candidateJobApplications);
        })->paginate(4, $cols);

        return CandidateJobFeatured::collection($featuredJobs);
    }
}
