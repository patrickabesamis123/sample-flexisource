<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateNotificationSettingsInterface;

class CandidateNotificationSettingsController extends Controller
{
    private $candidate_notification_settings_repo;

    public function __construct(CandidateNotificationSettingsInterface $candidate_notification_settings_repo)
    {   
        $this->candidate_notification_settings_repo = $candidate_notification_settings_repo;
    }

    /**
     * Get All Notification Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->candidate_notification_settings_repo->getSettings($request);
    }

    /**
     * Update Notification Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->candidate_notification_settings_repo->updateSettings($request);
    }
}
