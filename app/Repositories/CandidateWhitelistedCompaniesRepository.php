<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateWhitelistedCompaniesInterface;
use App\Models\Candidate;
use App\Models\WhitelistedCompany;

/**
 * Class CandidateWhitelistedCompaniesRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateWhitelistedCompaniesRepository extends BaseRepository implements CandidateWhitelistedCompaniesInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WhitelistedCompany::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get Whitelisted Companies
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function getWhitelistedCompanies($request)
    {   
        $whitelisted_companies = WhitelistedCompany::where('candidate_id', $request->candidate_id)
                                    ->where('enabled', 1)
                                    ->where('requested', 0)
                                    ->with('companies')
                                    ->get();
        return $whitelisted_companies;
        
    }

    /**
     * Get Requested Whitelisted Companies
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function getRequestedWhitelistCompanies($request)
    {   
        $requested_whitelisted_companies = WhitelistedCompany::where('candidate_id', $request->candidate_id)
                                    ->where('enabled', 0)
                                    ->where('requested', 1)
                                    ->with('companies')
                                    ->get();
        return $requested_whitelisted_companies;
        
    }

    /**
     * Store Whitelisted Companies
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function storeWhitelistedCompanies($request)
    {   
        $company_ids = $request->company_ids;
        $this->setEnableStatustoFalse($request->candidate_id);
        $update_counter = 0;
        
        foreach ($company_ids as $company_id) {
            $whitelisted_company = WhitelistedCompany::where('candidate_id', $request->candidate_id)
                                        ->where('company_id', $company_id)
                                        ->update(['enabled' => 1]);
            if ($whitelisted_company > 0) {
                $update_counter +=1;
            } else {
                $new_whitelisted_company = new WhitelistedCompany;
                $new_whitelisted_company->candidate_id = $request->candidate_id;
                $new_whitelisted_company->company_id = $company_id;
                $new_whitelisted_company->enabled = 1;
                $new_whitelisted_company->requested = 0;
                $new_whitelisted_company->recorded_date = date('Y-m-d h:i:s');
                $new_whitelisted_company->save();

                $update_counter +=1;
            }
        }

        if ($update_counter === count($company_ids)) 
            return $this->response(true, 'Settings was successfully saved', 200);
        
        return $this->response(false, 'No record to be updated', 400);
        
    }

    /**
     * Allow Whitelist Company
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function allowWhitelistCompany($request)
    {   
        $allow_company = WhitelistedCompany::where('candidate_id', $request->candidate_id)
                                    ->where('company_id', $request->company_id)
                                    ->update(['enabled' => 1, 'requested' => 0, 'updated_date' => date('Y-m-d h:i:s')]);
        return $allow_company;
    }

    /**
     * Decline Whitelist Company
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function declineWhitelistCompany($request)
    {   
        $decline_company = WhitelistedCompany::where('candidate_id', $request->candidate_id)
                                    ->where('company_id', $request->company_id)
                                    ->update(['enabled' => 0, 'requested' => 0, 'updated_date' => date('Y-m-d h:i:s')]);
        return $decline_company;
    }
    

    /**
     * Set the enabled = 0 of the Whitelisted Companies
     *
     * @param [String] $candidate_id
     * @return void
     */
    private function setEnableStatustoFalse($candidate_id)
    {
        $whitelisted_companies = WhitelistedCompany::where('candidate_id', $candidate_id)
                                    ->update(['enabled' => 0]);
        return $whitelisted_companies;
    }

    /**
     * Return Formatted JSON Response
     *
     * @param [Boolean] $success
     * @param [String] $message
     * @param [Integer] $status
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($success, $message, $status)
    {
        return response()->json(['success' => $success, 'message' => $message], $status);
    }


}