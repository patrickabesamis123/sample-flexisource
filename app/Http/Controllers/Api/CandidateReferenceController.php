<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateReferenceInterface;
use Illuminate\Http\JsonResponse;
use \App\Models\CandidateReference;

class CandidateReferenceController extends Controller
{            
    /** @var \App\Repositories\Contracts\CandidateReferenceInterface */
    private $referenceRepo;

    /**
     * CandidateWorkHistoryController constructor.
     *
     * @param App\Repositories\Contracts\CandidateReferenceInterface $workHistoryRepo
     */
    public function __construct(CandidateReferenceInterface $referenceRepo)
    {
        $this->referenceRepo = $referenceRepo;
    }

    /**
     * Create the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            // create new reference
            $query = $this->referenceRepo->createReference($request['data']);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }
        return response()->json($query, 201);
    }

    /**
     * Udpate the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $referenceId)
    {
        try{
            // update reference
            $query = $this->referenceRepo->updateReference($request['data'], $referenceId);
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
    public function destroy($referenceId)
    {
        try{
            // delete reference
            $query = $this->referenceRepo->deleteReference($referenceId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }
        return response()->json($query, 200);
    }
}
