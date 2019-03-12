<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\IndustryInterface;

class IndustryController extends Controller
{
    /**
     * @var IndustryRepository
     */
    private $repository;

    const ALL = 'all';

    /**
     * Constructor setup
     *
     * @param IndustryRepository $repository
     */
    public function __construct(IndustryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handles incoming HTTP requests
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
        switch ($request->type) {
            case self::ALL:
                return $this->repository->fetchIndustriesAndSubIndustries();
                break;
            default:
                return $this->repository->all();
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listParent()
    {
        try{
            // get parent industries
            $query = $this->repository->listParent();
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listParentAndSub()
    {
        try{
            // get parent industries and child
            $query = $this->repository->listParentAndSub();
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }


}
