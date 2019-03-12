<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateJobApplicationInterface;
use Illuminate\Http\JsonResponse;

class CandidateApplicationController extends Controller
{
    /** @var \App\Repositories\Contracts\CandidateJobApplicationInterface */
    private $candidateJobAppRepo;

    public function __construct(CandidateJobApplicationInterface $candidateJobAppRepo)
    {
        $this->candidateJobAppRepo = $candidateJobAppRepo;
    }
    
    /**
     * Show candidate job application
     *
     * @param Illuminate\Http\Request $request
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($candidateId, $status): JsonResponse
    {
        try{
            // get job application details
            $jobApplication = $this->candidateJobAppRepo->getJobApplicationByStatus($candidateId, $status);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($jobApplication, 200);
    }

}
