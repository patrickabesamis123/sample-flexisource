<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateWorkHistoryInterface;
use Illuminate\Http\JsonResponse;
use \App\Models\CandidateWorkhistory;

class CandidateWorkHistoryController extends Controller
{            
    /** @var \App\Repositories\Contracts\CandidateWorkHistoryInterface */
    private $workHistoryRepo;

    /**
     * CandidateWorkHistoryController constructor.
     *
     * @param App\Repositories\Contracts\CandidateWorkHistoryInterface $workHistoryRepo
     */
    public function __construct(CandidateWorkHistoryInterface $workHistoryRepo)
    {
        $this->workHistoryRepo = $workHistoryRepo;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            // create new user work history
            $query = $this->workHistoryRepo->createWorkHistory($request['data']);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 201);
    }

    /**
     * Update the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $workHistoryId)
    {
        try{
            // update work history
            $query = $this->workHistoryRepo->updateWorkHistory($request['data'], $workHistoryId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json(['success' => true], 201);
    }

    /**
     * Delete the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($workHistoryId): string
    {
        try{
            // delete candidate work history
            $query = $this->workHistoryRepo->deleteWorkHistory($workHistoryId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 201);
    }
}
