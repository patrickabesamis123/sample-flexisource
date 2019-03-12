<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\JobMetaInterface;

class JobMetaController extends Controller
{

    private $jobMetaRepo;

    /**
     * Constructor setup
     *
     * @param IndustryRepository $repository
     */
    public function __construct(JobMetaInterface $jobMetaRepo)
    {
        $this->jobMetaRepo = $jobMetaRepo;
    }

    /**
     * Get the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRequirementsCheck($jobId, $candidateId)
    {
        try{
            // get application requirements via job object id
            $query = $this->jobMetaRepo->getRequirementsCheck($jobId, $candidateId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

}
