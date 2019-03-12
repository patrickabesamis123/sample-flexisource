<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidatePrivacySettingsInterface;

class CandidatePrivacySettingsController extends Controller
{
    private $candidate_privacy_settings_repo;

    public function __construct(CandidatePrivacySettingsInterface $candidate_privacy_settings_repo)
    {   
        $this->candidate_privacy_settings_repo = $candidate_privacy_settings_repo;
    }

    /**
     * Get All Privacy Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->candidate_privacy_settings_repo->getSettings($request);
    }

    /**
     * Update Privacy Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->candidate_privacy_settings_repo->updateSettings($request);
    }
}
