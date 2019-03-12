<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CandidateEmailSettingsInterface;

class CandidateEmailSettingsController extends Controller
{
    private $candidate_email_settings_repo;

    public function __construct(CandidateEmailSettingsInterface $candidate_email_settings_repo)
    {   
        $this->candidate_email_settings_repo = $candidate_email_settings_repo;
    }

    /**
     * Get All Email Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->candidate_email_settings_repo->getSettings($request);
    }

    /**
     * Update Email Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->candidate_email_settings_repo->updateSettings($request);
    }

}
