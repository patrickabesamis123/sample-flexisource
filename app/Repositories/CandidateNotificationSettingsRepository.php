<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateNotificationSettingsInterface;
use App\Models\CandidateNotificationSettings;
use App\Models\Candidate;

/**
 * Class CandidateNotificationSettingsRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateNotificationSettingsRepository extends BaseRepository implements CandidateNotificationSettingsInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CandidateNotificationSettings::class;
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
                            ->with('notificationSetting')
                            ->first();
        if ($candidate) {
            $notification_settings = $candidate->notificationSetting;
            return $notification_settings;
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
        $notification_settings = CandidateNotificationSettings::where('candidate_id', $request->candidate_id)->first();
        
        // If Candidate Settings not exists - INSERT
        if ($notification_settings === null) {
            $new_notification_settings = new CandidateNotificationSettings;
            $new_notification_settings->candidate_id = $request->candidate_id;
            $new_notification_settings->direct_messages = $request->direct_messages;
            $new_notification_settings->new_roles = $request->new_roles;
            $new_notification_settings->new_roles_frequency = $request->new_roles_frequency;
            $new_notification_settings->view_profile = $request->view_profile;
            $new_notification_settings->recorded_date = date('Y-m-d h:i:s');

            if ($new_notification_settings->save()) {
                return $this->response(true, 'Settings was successfully added!', 200);
            }
        }

        // If Settings already exists - UPDATE
        $notification_settings->candidate_id = $request->candidate_id;
        $notification_settings->direct_messages = $request->direct_messages;
        $notification_settings->new_roles = $request->new_roles;
        $notification_settings->new_roles_frequency = $request->new_roles_frequency;
        $notification_settings->view_profile = $request->view_profile;
        $notification_settings->updated_date = date('Y-m-d h:i:s');

        if ($notification_settings->save()) {
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