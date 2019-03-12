<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountriesController extends Controller
{
    /**
     * Handle Incoming HTTP Request
     *
     * @return void
     */
    public function __invoke()
    {
        return response()->json(Country::select('id', 'displayName')->get());
    }
}
