<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\JobInterface;
use App\Validators\JobValidator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JobMeta;
use App\Models\Location;
use App\Models\Country;
use App\Models\CompanyFollower;
use App\Models\CandidateJobApplication;
use App\Services\CandidateJobAppService;

/**
 * Class JobRepository.
 *
 * @package namespace App\Repositories;
 */
class JobRepository extends BaseRepository implements JobInterface
{
    /*
     * @var Job
     */
    private $job;

    /**
     * Constructor setup
     *
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Job::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Check if object id exist
     */
    public function checkOjectIdExist($objectId)
    {
        $response = false;

        if(!empty($objectId)) {
            $job = Job::select('id')->where('object_id', $objectId)->get();

            if(isset($job[0]['id'])) {
                $response = true;
            }
        }

        return $response;
    }

    /**
     * Get Job details
     */
    public function getDetails($objectId)
    {
        $job = Job::where('object_id', $objectId)
                ->with('company')
                ->with('role_type')
                ->with('job_meta')
                ->with('location')
                ->with('industry')
                ->with('accountabilities')
                ->with('requirements')
                ->with('objectives')
                ->first();
        
        //format time
        $job['start_time'] = date("g:i A", strtotime($job['start_time']));
        $job['finish_time'] = date("g:i A", strtotime($job['finish_time']));

        $job['job_listed_date'] = date("l, d F, Y", strtotime($job['recorded_date']));
        $job['listing_expired_date'] = date("l, d F, Y", strtotime($job['expiry_date']));

        //get application requirements
        $jobMeta = JobMeta::select('meta_value')
                    ->where('job_id', $job['id'])
                    ->where('meta_key', '_application_requirements')
                    ->first();

        //get job video url
        $jobVideoUrl = JobMeta::select('meta_value')
                    ->where('job_id', $job['id'])
                    ->where('meta_key', 'job_video_url')
                    ->first();

        $job['application_requirements'] = json_decode($jobMeta['meta_value']);
        $job['job_video_url'] = $jobVideoUrl['meta_value'];

        //get company_extra_data
        $countFollowers = CompanyFollower::where('company_id', $job['company_id'])->count();

        $activeJob = Job::where('company_id', $job['company_id'])
                       ->where('job_status', 'active')
                       ->where('object_id', '!=', $objectId)
                       ->with('company')
                       ->with('role_type')
                       ->get();

        $job['company_extra_data'] = array('followers' => $countFollowers, 
                                           'active_jobs' => array('results' => array('jobs' => json_decode($activeJob) ) ) );

        return $job;
    }

    public function getJobTally($company_id){
        return DB::table('j_job')
                ->select('job_status', DB::raw('count(*) as total'))
                ->where('company_id', $company_id)
                ->whereIn('job_status', array('active', 'draft', 'closed'))
                ->groupby('job_status')
                ->get();
    }

    /**
     * Get Job Search Widget
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function getJobSearchWidget($request)
    {   
        if ($request->all()) {
                $company_id = $request->cid;
                $group_by = $request->group_by;
                $groups = $request->groups;
                $search_params = $request->q;
                
                $job = Job::where('company_id', $company_id)
                            ->where('job_status', 'active')
                            ->with('location')
                            ->with('role_type')
                            ->with('job_meta_video_url')
                            ->with('company')
                            ->with('industry');
                
                if ($search_params != null) {
                    $job->orWhere('object_id', 'LIKE', '%' . $search_params . '%')
                        ->orWhere('job_title', 'LIKE', '%' . $search_params . '%')
                        ->orWhere('job_description', 'LIKE', '%' . $search_params . '%');
                }

                if ($group_by === 'location') {
                    $job->orderBy('location_id', 'ASC');
                } elseif ($group_by === 'department') {
                    $job->orderBy('industry_id', 'ASC');
                } else {
                    $job = $job;
                }
                return $job->get();

        }

        return response()->json(["success" => false, "message" => "Required parameters were missing"], 400);
    }

    /**
     * Get Application Details
     *
     * @param [object] $candidateId
     * @return \Illuminate\Http\Response
     */
    public function getApplicationDetails($candidateId, $jobObjectId) 
    {
        $job = Job::where('object_id', $jobObjectId)
                    ->with('location')
                    ->with('company')
                    ->first();

        $response['job'] = $job;       
        
        $cJobApplication = CandidateJobApplication::where('job_id', $job['id'])
                            ->where('candidate_id', $candidateId)
                            ->first();

        $response['application']['applied_date'] = $cJobApplication['recorded_date'];
        $response['application']['application_id'] = $cJobApplication['object_id'];

        $candidateJobAppService = new CandidateJobAppService;

        $response['application']['application_questions'] = $candidateJobAppService->getApplicationQuestions($cJobApplication['id']);
        $response['application']['pre_apply_questions'] = $candidateJobAppService->getPreApplyQuestions($cJobApplication['id']);

        //$response['data'] = $response;
        return $response;
    }

    /**
     * Get Job Search Result.
     *
     * @param [string] $field
     * @param [string] $value
     * @return \Illuminate\Http\Response
     */
    public function filterJob($field, $value) 
    {
        return Job::like($field, $value);
    }

    /**
     * Filter Jobs.
     *
     * @param [array] $search
     * @return \Illuminate\Http\Response
     */
    public function filterJobs(array $search = []) 
    {
        $job = Job::where('job_status', 'active')
                    ->with('location')
                    ->with('role_type')
                    ->with('job_meta_video_url')
                    ->with('company')
                    ->with('industry');
        $job->where('min_salary', '>=', $search['min_salary']);
        $job->where('max_salary', '<=', $search['max_salary']);

        if($search['q']) {
            $job->likeJobTitle($search['q']);
        }
        
        if($search['role_type']) {
            $role_types = explode(",",$search['role_type']);
            $job->whereIn('role_type_id', $role_types);
        }

        if($search['industry']) {
            $selected_industries = explode(",",$search['industry']);
            $industries = Industry::whereIn('parent_id', $selected_industries)->pluck('id');
            $job->whereIn('industry_id', $industries);
        }

        if($search['sub_industry']) {
            $selected_sub_industries = explode(",",$search['sub_industry']);
            $job->whereIn('industry_id', $selected_sub_industries);
        }

        if($search['location']) {
            $location_ids = Location::where('display_name', 'like', '%' . $search['location'] . '%')->pluck('id');
            $job->whereIn('location_id', $location_ids);
        }

        if($search['country']) {
            $selected_country = Country::where('codeSlugName', $search['country'])->first();
            $location_ids = Location::where('country_id', $selected_country->id)->pluck('id');
            $job->whereIn('location_id', $location_ids);
        }
        
        return $job->paginate(10);
    }
}
