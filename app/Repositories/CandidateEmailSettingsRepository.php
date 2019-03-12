<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateEmailSettingsInterface;
use App\Models\CandidateEmailSettings;
use App\Models\Candidate;

/**
 * Class CandidateEmailSettingsRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateEmailSettingsRepository extends BaseRepository implements CandidateEmailSettingsInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CandidateEmailSettings::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get Settings
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function getSettings($request)
    {
        $candidate = Candidate::where('user_id', $request->candidate_id)
                                ->with('emailSetting')
                                ->first();
        if ($candidate) {
            $email_settings = $candidate->emailSetting;
            return $email_settings;
        }
    }

    /**
     * Update Settings
     *
     * @param [object] $request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings($request)
    {   
        $email_settings = CandidateEmailSettings::where('candidate_id', $request->candidate_id)->first();
        
        // If Candidate Settings not exists - INSERT
        if ($email_settings === null) {
            $new_email_settings = new CandidateEmailSettings;
            $new_email_settings->candidate_id = $request->candidate_id;
            $new_email_settings->direct_messages = $request->direct_messages;
            $new_email_settings->profile_metrics = $request->profile_metrics;
            $new_email_settings->profile_metrics_frequency = $request->profile_metrics_frequency;
            $new_email_settings->view_profile = $request->view_profile;
            $new_email_settings->newsletters = $request->newsletters;
            $new_email_settings->newsletters_frequency = $request->newsletters_frequency;
            $new_email_settings->recorded_date = date('Y-m-d h:i:s');

            if ($new_email_settings->save()) {
                return $this->response(true, 'Settings was successfully added!', 200);
            }
        }

        // If Settings already exists - UPDATE
        $email_settings->candidate_id = $request->candidate_id;
        $email_settings->direct_messages = $request->direct_messages;
        $email_settings->profile_metrics = $request->profile_metrics;
        $email_settings->profile_metrics_frequency = $request->profile_metrics_frequency;
        $email_settings->view_profile = $request->view_profile;
        $email_settings->newsletters = $request->newsletters;
        $email_settings->newsletters_frequency = $request->newsletters_frequency;
        $email_settings->updated_date = date('Y-m-d h:i:s');

        if ($email_settings->save()) {
            return $this->response(true, 'Settings was successfully updated!', 200);
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