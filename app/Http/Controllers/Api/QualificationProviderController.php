<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\QualificationProviderInterface;
use Illuminate\Http\JsonResponse;

class QualificationProviderController extends Controller
{
    /** @var \App\Repositories\Contracts\QualificationProviderInterface */
    private $qualificationProviderRepo;

    /**
     * QualificationController constructor.
     *
     * @param App\Repositories\Contracts\QualificationProviderInterface $qualificationRepo
     */
    public function __construct(QualificationProviderInterface $qualificationProviderRepo)
    {
        $this->qualificationProviderRepo = $qualificationProviderRepo;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function autoComplete($displayName, $limit): JsonResponse
    {
        try{
            // get qualification list
            $query = $this->qualificationProviderRepo->search($displayName, $limit);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json(['data' => $query], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(): JsonResponse
    {
        try{
            // get qualification provider list
            $query = $this->qualificationProviderRepo->list();
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

}
