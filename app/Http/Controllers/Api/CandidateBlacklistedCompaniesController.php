<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateBlacklistedCompaniesInterface;

class CandidateBlacklistedCompaniesController extends Controller
{
    private $candidate_blacklisted_companies_repo;

    public function __construct(CandidateBlacklistedCompaniesInterface $candidate_blacklisted_companies_repo)
    {   
        $this->candidate_blacklisted_companies_repo = $candidate_blacklisted_companies_repo;
    }

    /**
     * Get All Blacklisted Companies
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->candidate_blacklisted_companies_repo->getBlacklistedCompanies($request);
    }

    /**
     * Store Blacklisted Companies
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeBlacklistedCompanies(Request $request)
    {
        return $this->candidate_blacklisted_companies_repo->storeBlacklistedCompanies($request);
    }

}
