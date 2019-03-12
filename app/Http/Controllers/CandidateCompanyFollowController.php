<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Http\Resources\CompanyCollection;

class CandidateCompanyFollowController extends Controller
{
    /**
     * Handle Incoming HTTP Request
     *
     * @return void
     */
    public function __invoke()
    {
        $candidate = Candidate::latest()->first();
        return new CompanyCollection($candidate->companyFollowers()->paginate(10));
    }
}
