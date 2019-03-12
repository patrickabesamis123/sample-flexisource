<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\QualificationInterface;
use Illuminate\Http\JsonResponse;

class QualificationController extends Controller
{
    /** @var \App\Repositories\Contracts\QualificationInterface */
    private $qualificationRepo;

    /**
     * QualificationController constructor.
     *
     * @param App\Repositories\Contracts\QualificationInterface $qualificationRepo
     */
    public function __construct(QualificationInterface $qualificationRepo)
    {
        $this->qualificationRepo = $qualificationRepo;
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
            $query = $this->qualificationRepo->search($displayName, $limit);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(): JsonResponse
    {
        try{
            // get qualification list
            $query = $this->qualificationRepo->list();
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

}
