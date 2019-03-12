<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateBlacklistedCompaniesInterface;
use App\Models\Candidate;
use App\Models\BlacklistedCompany;

/**
 * Class CandidateBlacklistedCompaniesRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateBlacklistedCompaniesRepository extends BaseRepository implements CandidateBlacklistedCompaniesInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BlacklistedCompany::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get Blacklisted Companies
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function getBlacklistedCompanies($request)
    {   
        $blacklisted_companies = BlacklistedCompany::where('candidate_id', $request->candidate_id)
                                    ->where('enabled', 1)
                                    ->with('companies')
                                    ->get();
        return $blacklisted_companies;
        
    }

    /**
     * Store Blacklisted Companies
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function storeBlacklistedCompanies($request)
    {   
        $company_ids = $request->company_ids;
        $this->setEnableStatustoFalse($request->candidate_id);
        $update_counter = 0;
        
        foreach ($company_ids as $company_id) {
            $blacklisted_company = BlacklistedCompany::where('candidate_id', $request->candidate_id)
                                        ->where('company_id', $company_id)
                                        ->update(['enabled' => 1]);
            if ($blacklisted_company > 0) {
                $update_counter +=1;
            } else {
                $new_blacklisted_company = new BlacklistedCompany;
                $new_blacklisted_company->candidate_id = $request->candidate_id;
                $new_blacklisted_company->company_id = $company_id;
                $new_blacklisted_company->enabled = 1;
                $new_blacklisted_company->recorded_date = date('Y-m-d h:i:s');
                $new_blacklisted_company->save();

                $update_counter +=1;
            }
        }

        if ($update_counter === count($company_ids)) 
            return $this->response(true, 'Settings was successfully saved', 200);
        
        return $this->response(false, 'No record to be updated', 400);
        
    }

    /**
     * Set the enabled = 0 of the Blacklisted Companies
     *
     * @param [String] $candidate_id
     * @return Integer
     */
    private function setEnableStatustoFalse($candidate_id)
    {
        $blacklisted_companies = BlacklistedCompany::where('candidate_id', $candidate_id)
                                    ->update(['enabled' => 0]);
        return $blacklisted_companies;
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