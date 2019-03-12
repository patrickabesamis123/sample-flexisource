<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use App\Repositories\Contracts\CompanyInterface;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Requests\Company\CompanyTeamRequest;
use App\Http\Requests\Company\CompanyTeamInviteRequest;

class CompanyController extends Controller
{
    private $company;

    public function __construct(CompanyInterface $company)
    {
        $this->company = $company;
    }

    public function index(Request $request)
    {
        return $this->company->getInfoByUrl($request->company_url);
    }

    /**
     * Company Edit
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        return $this->company->getInfoById($request->company_id);
    }

    /**
     * Compant Update
     *
     * @param CompanyUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CompanyUpdateRequest $request)
    {
        return $this->company->updateInfo($request);
    }

    /**
     * Get Company Employers
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployers(Request $request)
    {
        return $this->company->getEmployers($request->company_id);
    }

    /**
     * Get Company Teams
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeams(Request $request)
    {
        return $this->company->getTeams($request);
    }

    /**
     * Create Company Team
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTeam(CompanyTeamRequest $request)
    {
        return $this->company->storeTeam($request);
    }

    /**
     * Update Company Team
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTeam(CompanyTeamRequest $request)
    {
        return $this->company->updateTeam($request);
    }

    /**
     * Delete Company Team
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyTeam(Request $request)
    {
        return $this->company->destroyTeam($request);
    }

    /**
     * Get Company Team Members
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeamMembers(Request $request)
    {
        return $this->company->getTeamMembers($request);
    }

    /**
     * Delete Company Team Members
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyTeamMember(Request $request)
    {
        return $this->company->destroyTeamMember($request);
    }

    /**
     * Store Invited Company Team Member
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeInvitedTeamMember(CompanyTeamInviteRequest $request)
    {
        return $this->company->storeInvitedTeamMember($request);
    }

    /**
     * Get All Active Companies
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActiveCompanies()
    {
        return $this->company->getActiveCompanies();
    }

}
