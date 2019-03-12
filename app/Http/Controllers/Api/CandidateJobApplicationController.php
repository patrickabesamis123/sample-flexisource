<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CandidateJobApplication as CandidateJobApplicationResource;
use App\Http\Resources\ClosedJobApplication as ClosedJobApplicationResource;
use App\Http\Resources\AppliedJobApplication as AppliedJobApplicationResource;
use App\Repositories\Contracts\CandidateJobApplicationInterface;
use App\Models\Job;
use App\Models\CandidateJobApplication;

class CandidateJobApplicationController extends Controller
{
    private $repository;

    public function __construct(CandidateJobApplicationInterface $repository)
    {
        $this->repository = $repository;
    }
  
    public function getByType(Request $request)
    {
        switch ($request->type) {
            case Job::CLOSED:
                return ClosedJobApplicationResource::collection($this->repository->getClosedJobApplication());
                break;
            case CandidateJobApplication::APPLIED:
                return AppliedJobApplicationResource::collection($this->repository->getAppliedJobApplication());
                break;
            default:
                return $this->repository->all();
                break;
        }
    }

    public function getSteps($jobObjId)
    {
        try{
            // get candidate application application steps
            $query = $this->repository->getSteps($jobObjId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

    /**
     * Save the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPreApplyQuestions(Request $request, $jobObjId)
    {
        try{
            // update on c_job_app_ques_answer table
            $query = $this->repository->postPreApplyQuestions($request['data'], $jobObjId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }


    /**
     * Save the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRequirementsCheck(Request $request, $jobObjId , $applicationObjId)
    {
        try{
            // update on c_job_app_ques_answer table
            $query = $this->repository->postRequirementsCheck($request['data'], $jobObjId , $applicationObjId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }


    /**
     * Save the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postQuestions(Request $request, $jobObjId , $applicationObjId)
    {
        try{
            // update
            $query = $this->repository->postQuestions($request['data'], $jobObjId , $applicationObjId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }


}
