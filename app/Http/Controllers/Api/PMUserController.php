<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PMUserInterface;
use Illuminate\Http\JsonResponse;

class PMUserController extends Controller
{
    /** @var \App\Repositories\Contracts\PMUserInterface */
    private $pmUserRepo;

    /**
     * PMUserController constructor.
     *
     * @param App\Repositories\Contracts\PMUserInterface $pmUserRepo
     */
    public function __construct(PMUserInterface $pmUserRepo)
    {
        $this->pmUserRepo = $pmUserRepo;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(): JsonResponse
    {
        try{
            // get user details
            $query = $this->pmUserRepo->getDetails(auth()->user()->id);
            
            if(empty($query)) {
                return response()->json(['error'=>'User not found'], 404);
            }
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

    
    /**
     * Update PM user
     *
     * @param Illuminate\Http\Request $request
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateName(Request $request, $id): JsonResponse
    {
        try{
            // update on pm_user table
            $pmUser = $this->pmUserRepo->updateName($request['data'], $id);
            $response = array('ProfileUpdated' => true);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }
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
            // update on `pm_user` table
            $pmUser = $this->pmUserRepo->updateByPMUserId($request['data'], $id);
            $response = array('ProfileUpdated' => true);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($response, 200);
    }

}
