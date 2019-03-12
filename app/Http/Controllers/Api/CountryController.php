<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CountryInterface;
use Illuminate\Http\JsonResponse;
use \App\Models\Country;

class CountryController extends Controller
{            
    /** @var \App\Repositories\Contracts\CountryInterface */
    private $countryRepo;

    /**
     * CountryController constructor.
     *
     * @param App\Repositories\Contracts\CountryInterface $countryRepo
     */
    public function __construct(CountryInterface $countryRepo)
    {
        $this->countryRepo = $countryRepo;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(): JsonResponse
    {
        try{
            // get country list
            $query = $this->countryRepo->list();
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }
}
