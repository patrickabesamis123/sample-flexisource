<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateInterface;
use App\Repositories\Contracts\PMUserInterface;
use Illuminate\Http\JsonResponse;

class CandidateController extends Controller
{
    /** @var \App\Repositories\Contracts\CandidateInterface */
    private $candidateRepo;

    /** @var \App\Repositories\Contracts\PMUserInterface */
    private $pmUserRepo;

    /**
     * CandidateController constructor.
     *
     * @param App\Repositories\Contracts\PMUserInterface $candidateRepo
     */
    public function __construct(CandidateInterface $candidateRepo, PMUserInterface $pmUserRepo)
    {
        $this->candidateRepo = $candidateRepo;
        $this->pmUserRepo = $pmUserRepo;
    }
    
    /**
     * Update PM user
     *
     * @param Illuminate\Http\Request $request
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateByPMUserId(Request $request, $id): JsonResponse
    {
        try{
            // update on `candidate` table
            $candidate = $this->candidateRepo->updateByPMUserId($request['data'], $id);

            // update on `pm_user` table
            $user = $this->pmUserRepo->updateByPMUserId($request['data'], $id);

            $response = array('ProfileUpdated' => true);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($response, 200);
    }

    /**
     * Update Candidate user
     *
     * @param Illuminate\Http\Request $request
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try{
            // update on `candidate` table
            $candidate = $this->candidateRepo->updateByPMUserId($request['data'], $id);

            $response = array('ProfileUpdated' => true);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($response, 200);
    }

    /**
     * Show Candidate Details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        return $this->candidateRepo->show($request);
    }

    /**
     * Update Candidate Location
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLocation(Request $request, $id)
    {
        return $this->candidateRepo->updatePreferredLocation($request->all(), $id);
    }

    /**
     * Update Candidate Email Address
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmailAddress(Request $request)
    {
        return $this->candidateRepo->updateEmailAddress($request);
    }

    /**
     * Update Candidate Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        return $this->candidateRepo->updatePassword($request);
    }

    /**
     * Update Candidate Profile Url
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfileUrl(Request $request)
    {
        return $this->candidateRepo->updateProfileUrl($request);
    }

    /**
     * Update Candidate Status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        return $this->candidateRepo->updateStatus($request);
    }

}
