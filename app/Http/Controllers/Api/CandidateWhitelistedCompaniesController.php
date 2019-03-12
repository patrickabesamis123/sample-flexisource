<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateWhitelistedCompaniesInterface;

class CandidateWhitelistedCompaniesController extends Controller
{
    private $candidate_whitelisted_companies_repo;

    public function __construct(CandidateWhitelistedCompaniesInterface $candidate_whitelisted_companies_repo)
    {   
        $this->candidate_whitelisted_companies_repo = $candidate_whitelisted_companies_repo;
    }

    /**
     * Get All Whitelisted Companies
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->candidate_whitelisted_companies_repo->getWhitelistedCompanies($request);
    }

    /**
     * Get Requested Whitelisted Companies
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getRequestedWhitelistCompanies(Request $request)
    {
        return $this->candidate_whitelisted_companies_repo->getRequestedWhitelistCompanies($request);
    }

    /**
     * Store Whitelisted Companies
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeWhitelistedCompanies(Request $request)
    {
        return $this->candidate_whitelisted_companies_repo->storeWhitelistedCompanies($request);
    }

    /**
     * Allow Whitelist Company
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function allowWhitelistCompany(Request $request)
    {
        return $this->candidate_whitelisted_companies_repo->allowWhitelistCompany($request);
    }

    /**
     * Decline Whitelist Company
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function declineWhitelistCompany(Request $request)
    {
        return $this->candidate_whitelisted_companies_repo->declineWhitelistCompany($request);
    }
}
