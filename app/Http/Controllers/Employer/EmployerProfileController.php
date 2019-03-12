<?php

namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Http\Controllers\Controller;

class EmployerProfileController extends Controller
{
    private $employer;
    public function __construct() {
        $this->employer = \App::call('App\Http\Controllers\AuthController@getAuthenticatedUser');
    }

    public function index() {
        return response()->json(['job_title'=> true, 'message'=> $this->employer]);
    }
}
