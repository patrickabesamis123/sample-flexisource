<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\LocationInterface;
use Illuminate\Http\JsonResponse;
use \App\Models\Location;

class LocationController extends Controller
{            
    /** @var \App\Repositories\Contracts\LocationInterface */
    private $locationRepo;

    /**
     * LocationController constructor.
     *
     * @param App\Repositories\Contracts\LocationInterface $locationRepo
     */
    public function __construct(LocationInterface $locationRepo)
    {
        $this->locationRepo = $locationRepo;
    }

    /**
     * Fetch data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetchData(Request $request)
    {
        switch ($request->type) {
            case 'search-display':
                return $this->locationRepo->fetchLocationForSearchDisplay();
                break;
            default:
                return $this->locationRepo->all();
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autoComplete($data, $countryId): JsonResponse
    {
        try{
            // search location
            $query = $this->locationRepo->searchForAutoComplete($data, $countryId);
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
    public function autoCompleteSearch($data): JsonResponse
    {
        try{
            // search location for search
            $query = $this->locationRepo->searchForAutoCompleteSearch($data);
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
    public function searchForLocationByCountry($slug_code): JsonResponse
    {
        try{
            // search location for search
            $query = $this->locationRepo->searchForLocationByCountry($slug_code);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }
}
