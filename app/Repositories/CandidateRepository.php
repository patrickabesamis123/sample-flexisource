<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateInterface;
use App\Models\Candidate;
use App\Models\Location;
use App\Models\PmUser;
use App\Validators\CandidateValidator;

/**
 * Class CandidateRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateRepository extends BaseRepository implements CandidateInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Candidate::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Update data in database
     *
     * @param array $data
     * @param int $id
     * @return array
     */
    public function updateByPMUserId($data, $pmUserId)
    {   
        $fillable = ['user_id', 'nickaname', 'nationality_id', 'phone_number', 'mobile_number', 'work_type_id', 'dob',
                    'industry_id', 'min_salary', 'max_salary', 'long_description', 'preferred_location_id', 
                    'willing_to_relocate', 'new_to_workforce'];

        foreach ($data as $key => $value) {
            if(in_array($key, $fillable))
                $column[$key] = $value;
        }

        // update on `candidate` table
        $candidate = Candidate::where('user_id',$pmUserId)->update($column);

        return true;
    }
    
    /**
     * Get Candidate Details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($request)
    {   
        $candidate = Candidate::where('user_id', $request->candidate_id)->first();
        return $candidate;
    }

    /**
     * Update Candidate Preferred Location
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePreferredLocation($request, $id)
    {

        
    }

    /**
     * Update Candidate Email Address
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmailAddress($request)
    {
        $candidate = PmUser::where('username', $request->email)->first();

        if ($candidate) {
            $candidate->email = $request->new_email;
            $candidate->save();

            if (!$candidate->save()) {
                return $this->response(false, 'Failed to update Email Address', 400);
            }

            return $this->response(true, 'Email Address was successfully updated', 200);
        }
        
    }

    /**
     * Update Candidate Password
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword($request)
    {
        $candidate = PmUser::find($request->candidate_id);

        if ($candidate) {
            $candidate->password = \Hash::make($request->new_password);
            $candidate->save();

            if (!$candidate->save()) {
                return $this->response(false, 'Failed to update Password', 400);
            }

            return $this->response(true, 'Password was successfully updated', 200);
        }
        
    }

    /**
     * Update Candidate Profile Url
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfileUrl($request)
    {
        $candidate = Candidate::where('user_id', $request->candidate_id)->first();

        if ($candidate) {
            $candidate->profile_url = $request->new_profile_url;
            $candidate->save();

            if (!$candidate->save()) {
                return $this->response(false, 'Failed to update Profile Url', 400);
            }

            return $this->response(true, 'Profile Url was successfully updated', 200);
        }
        
    }

    /**
     * Update Candidate Status
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus($request)
    {   
        $candidate = PmUser::find($request->candidate_id);
        
        if ($candidate) {
            $candidate->enabled = PmUser::DISABLED;
            $candidate->save();

            if (!$candidate->save()) {
                return $this->response(false, 'Failed to update status', 400);
            }

            return $this->response(true, 'Status was successfully updated', 200);
        }
        
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
