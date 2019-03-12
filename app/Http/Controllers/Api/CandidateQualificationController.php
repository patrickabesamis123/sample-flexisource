<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateQualificationInterface;
use Illuminate\Http\JsonResponse;
use \App\Models\CandidateQualification;

class CandidateQualificationController extends Controller
{            
    /** @var \App\Repositories\Contracts\CandidateQualificationInterface */
    private $qualificationRepo;

    /**
     * CandidateWorkHistoryController constructor.
     *
     * @param App\Repositories\Contracts\CandidateQualificationInterface $workHistoryRepo
     */
    public function __construct(CandidateQualificationInterface $qualificationRepo)
    {
        $this->qualificationRepo = $qualificationRepo;
    }

    /**
     * Create the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$aa = reset($request);
        //return $aa;
        try{
            // create new candidate qualification
            $query = $this->qualificationRepo->createQualification($request['data']);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }
        return response()->json($query, 200);
    }

    /**
     * Udpate the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $qualificationId)
    {
        try{
            // update candidate qualification
            $query = $this->qualificationRepo->updateQualification($request['data'], $qualificationId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }
        return response()->json($query, 200);
    }

    /**
     * Destroy the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($qualificationId)
    {
        try{
            // delete candidate qualification
            $query = $this->qualificationRepo->deleteQualification($qualificationId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }
        return response()->json($query, 200);
    }
}
