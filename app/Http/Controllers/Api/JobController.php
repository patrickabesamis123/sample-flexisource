<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\JobInterface;
use App\Services\JobService;
use Illuminate\Http\JsonResponse;
use \App\Models\Job;

class JobController extends Controller
{
    /** @var \App\Repositories\Contracts\JobInterface */
    private $jobRepo;

    /** App\Services\JobService */
    private $jobService;

    /**
     * JobController constructor.
     *
     * @param App\Repositories\Contracts\JobInterface $jobRepo
     */
    public function __construct(JobInterface $jobRepo, JobService $jobService)
    {
        $this->jobRepo = $jobRepo;
        $this->jobService = $jobService;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $object_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetailsByObjectId($object_id): JsonResponse
    {
        try{
            // get job details
            $query = $this->jobRepo->getDetails($object_id);

            if(empty($query)) {
                return response()->json(['error'=>'Job not found'], 400);
            }
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }


    /**
     * Retrieve the tally of jobs under active, closed, and draft
     *
     * @param  int  $company_id
     * @return \Illuminate\Http\Response
     */
    public function getJobTally(Request $request)
    {
        return response()->json($this->jobRepo->getJobTally($request->company_id), 200);
    }

    /**
     * Retrieve the job roles depending on the status of the parameter and company id
     *
     * @param  int  $company_id
     * @param  String  $status
     * @return \Illuminate\Http\Response
     */
    public function getCompanyRoles(Request $request)
    {
        return response()->json($this->jobService->getCompanyRoles($request->company_id, $request->status), 200);
    }

    /**
     * Get Job Search Widget
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getJobSearchWidget(Request $request)
    {
        return $this->jobRepo->getJobSearchWidget($request);
    }

    /**
     * Get application details
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getApplicationDetails($candidateId, $jobObjectId)
    {
        return $this->jobRepo->getApplicationDetails($candidateId, $jobObjectId);
    }


}
