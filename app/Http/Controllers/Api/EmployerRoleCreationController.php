<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\EmployerRoleCreationInterface;
use Illuminate\Http\JsonResponse;
use \App\Models\Employer;
use JWTAuth;

class EmployerRoleCreationController extends Controller
{
    /** @var \App\Repositories\Contracts\EmployerRoleCreationInterface */
    private $rolecreation;

    /**
     * EmployerRoleCreationController constructor.
     *
     * @param App\Repositories\Contracts\EmployerRoleCreationInterface $rolecreation
     */
    public function __construct(EmployerRoleCreationInterface $rolecreation)
    {
        $this->rolecreation = $rolecreation;
    }

    /**
     * Display draft roles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function drafts(Request $request)
    {
        try{
            // authenticate user
            $user = JWTAuth::parseToken()->authenticate();
            $user = json_decode($user);
            $company_id = $this->rolecreation->getCompanyId($user->id);
            $query = $this->rolecreation->drafts($company_id, $request);

            if(empty($query)) {
                abort(404, 'Job not found');
            }

        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return $query;
    }

    /**
     * Display classifications
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function classifications(Request $request)
    {
        try{
            // authenticate user
            $user = JWTAuth::parseToken()->authenticate();
            $user = json_decode($user);
            $company_id = $this->rolecreation->getCompanyId($user->id);
            $query = $this->rolecreation->classifications($company_id, $request);

            if(empty($query)) {
                abort(404, 'Job not found');
            }

        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return $query;
    }

    /**
     * Display search results
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try{
            // authenticate user
            $user = JWTAuth::parseToken()->authenticate();
            $user = json_decode($user);
            $company_id = $this->rolecreation->getCompanyId($user->id);
            $query = $this->rolecreation->search($company_id, $request);

            if(empty($query)) {
                abort(404, 'Job not found');
            }

        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return $query;
    }

    /**
     * Preview role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function preview(Request $request)
    {
        try{
            // authenticate user
            $user = JWTAuth::parseToken()->authenticate();
            $user = json_decode($user);
            $company_id = $this->rolecreation->getCompanyId($user->id);
            $query = $this->rolecreation->preview($company_id, $request->template_id);

            if(empty($query)) {
                abort(404, 'Job not found');
            }

        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return $query;
    }
}
