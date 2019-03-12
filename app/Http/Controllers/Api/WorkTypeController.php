<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WorkTypeInterface;
use Illuminate\Http\JsonResponse;

class WorkTypeController extends Controller
{
    /**
     * @var [WorkTypeInterface]
     */
    private $repository;

    /**
     * Constructor setup
     *
     * @param WorkTypeInterface $repository
     */
    public function __construct(WorkTypeInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return $this->repository->all();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(): JsonResponse
    {
        try{
            // get worktype list list
            $query = $this->repository->list();
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

}
