<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\EmployerInterface;
use App\Http\Requests\Employer\UpdateEmailRequest;
use App\Http\Requests\Employer\UpdatePasswordRequest;
use App\Http\Requests\Employer\UpdateBasicInformationRequest;
use Illuminate\Http\JsonResponse;
use \App\Models\Employer;
use JWTAuth;

class EmployerController extends Controller
{
    /** @var \App\Repositories\Contracts\EmployerInterface */
    private $employer;

    /**
     * EmployerController constructor.
     *
     * @param App\Repositories\Contracts\EmployerInterface $employer
     */
    public function __construct(EmployerInterface $employer)
    {
        $this->employer = $employer;
    }

    public function index(Request $request)
    {
        return $this->employer->getInfoById($request->employer_id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function open_roles(Request $request)
    {
        try{
            // get open roles details
            $user = JWTAuth::parseToken()->authenticate();
            $user = json_decode($user);
            $employer_id = $this->employer->getEmployerId($user->id);
            $query = $this->employer->getOpenRoles($employer_id);

            if(empty($query)) {
                abort(404, 'Job not found');
            }

        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query);

    }

    /**
     * Display closed jobs
     *
     * @return \Illuminate\Http\Response
     */
    public function closed_jobs(Request $request)
    {
        try{
            // get closed jobs details
            $user = JWTAuth::parseToken()->authenticate();
            $user = json_decode($user);
            $employer_id = $this->employer->getEmployerId($user->id);
            $query = $this->employer->getClosedJobs($employer_id);

            if(empty($query)) {
                abort(404, 'Job not found');
            }

        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query);

    }

    /**
     * Display draft jobs
     *
     * @return \Illuminate\Http\Response
     */
    public function draft_jobs(Request $request)
    {
        try{
            // get draft jobs details
            $user = JWTAuth::parseToken()->authenticate();
            $user = json_decode($user);
            $employer_id = $this->employer->getEmployerId($user->id);
            $query = $this->employer->getDraftJobs($employer_id);

            if(empty($query)) {
                abort(404, 'Job not found');
            }

        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query);

    }

    /**
     * Display watchlist
     *
     * @return \Illuminate\Http\Response
     */
    public function watchlist(Request $request)
    {
        try{
            // get draft jobs details
            $user = JWTAuth::parseToken()->authenticate();
            $user = json_decode($user);
            $employer_id = $this->employer->getEmployerId($user->id);
            $query = $this->employer->getWatchlist($employer_id);

            if(empty($query)) {
                abort(404, 'Job not found');
            }

        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query);

    }
    
    /**
     * Updates Email Address
     *
     * @param UpdateEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail(UpdateEmailRequest $request)
    {   
        return $this->employer->updateEmail($request);
    }

    /**
     * Updates Password
     *
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        return $this->employer->updatePassword($request);
    }

    /**
     * Updates Basic Information
     *
     * @param UpdateBasicInformationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBasicInfo(UpdateBasicInformationRequest $request)
    {
        return $this->employer->updateBasicInfo($request);
    }

    /**
     * Updates Account Type
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAccountType(Request $request)
    {
        return $this->employer->updateAccountType($request);
    }

    /**
     * Updates Account Status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAccountStatus(Request $request)
    {
        return $this->employer->updateAccountStatus($request);
    }

    /**
     * Process Javascript Integration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeJsIntegrationRequest(Request $request)
    {
        return $this->employer->storeJsIntegrationRequest($request);
    }

    /**
     * Gets the Javascript Integration status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJsIntegrationStatus(Request $request)
    {
        return $this->employer->getJsIntegrationStatus($request);
    }

    /**
     * Gets Employers Permissions
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissions(Request $request)
    {
        return $this->employer->getPermissions($request);
    }

}
