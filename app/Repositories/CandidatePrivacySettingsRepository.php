<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidatePrivacySettingsInterface;
use App\Models\Privacy;
use App\Models\Candidate;

/**
 * Class CandidatePrivacySettingsRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidatePrivacySettingsRepository extends BaseRepository implements CandidatePrivacySettingsInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Privacy::class;
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
                            ->with('privacySetting')
                            ->first();
        if ($candidate) {
            $privacy_settings = $candidate->privacySetting;
            $privacy_settings->statements = $this->privacyStatements($privacy_settings);
            return $privacy_settings;
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
        $privacy_settings = Privacy::where('candidate_id', $request->candidate_id)->first();
        
        // If Candidate Settings not exists - INSERT
        if ($privacy_settings === null) {
            $new_privacy_settings = new Privacy;
            $new_privacy_settings->candidate_id = $request->candidate_id;
            $new_privacy_settings->type = $request->type;
            $new_privacy_settings->settings = json_encode([
                'seo_enabled' => $request->settings['seo_enabled'],
                'first_name' => $request->settings['first_name'],
                'last_name' => $request->settings['last_name'],
                'contact_number' => $request->settings['contact_number'],
                'email' => $request->settings['email'],
                'location' => $request->settings['location'],
                'about_me' => $request->settings['about_me'],
                'industry' => $request->settings['industry'],
                'sub_industry' => $request->settings['sub_industry'],
                'profile_photo' => $request->settings['profile_photo'],
                'generic_video' => $request->settings['generic_video'],
                'experience' => $request->settings['experience'],
                'education' => $request->settings['education'],
                'references' => $request->settings['references'],
                'resume' => $request->settings['resume'],
                'supporting_docs' => $request->settings['supporting_docs']
            ]);

            $new_privacy_settings->recorded_date = date('Y-m-d h:i:s');

            if ($new_privacy_settings->save()) {
                $privacy_statements = $this->privacyStatements($request);
                return $this->response(true, 'Settings was successfully added!', $privacy_statements, 200);
            }
        }

        // If Settings already exists - UPDATE
        $privacy_settings->candidate_id = $request->candidate_id;
        $privacy_settings->type = $request->type;
            $privacy_settings->settings = json_encode([
                'seo_enabled' => $request->settings['seo_enabled'],
                'first_name' => $request->settings['first_name'],
                'last_name' => $request->settings['last_name'],
                'contact_number' => $request->settings['contact_number'],
                'email' => $request->settings['email'],
                'location' => $request->settings['location'],
                'about_me' => $request->settings['about_me'],
                'industry' => $request->settings['industry'],
                'sub_industry' => $request->settings['sub_industry'],
                'profile_photo' => $request->settings['profile_photo'],
                'generic_video' => $request->settings['generic_video'],
                'experience' => $request->settings['experience'],
                'education' => $request->settings['education'],
                'references' => $request->settings['references'],
                'resume' => $request->settings['resume'],
                'supporting_docs' => $request->settings['supporting_docs']
            ]);
        $privacy_settings->updated_date = date('Y-m-d h:i:s');

        if ($privacy_settings->save()) {
            $privacy_statements = $this->privacyStatements($request);
            return $this->response(true, 'Settings was successfully updated!', $privacy_statements, 200);
        }   
    }

    /**
     * Process Privacy Statements
     *
     * @param [Object] $privacy_data
     * @return void
     */
    private function privacyStatements($privacy_data)
    {
        if ($privacy_data->type === 'private') {
            $statements = "Your profile is set to [PRIVATE] (our default setting)." . 
                "Only employers who you have granted permission to view (by submitting an application for an opportunity to an employer registered on PreviewMe, through PreviewMe or accepting a request by an employer registered on PreviewMe to view) can view your profile." .
                "People outside of PreviewMe [CANNOT VIEW] your profile and your profile [IS NOT] searchable on search engines." . 
                "You can change these privacy settings at anytime by clicking [HERE].";
        } else {
            if (gettype($privacy_data->settings) === 'object') {
                $isOrIsNot = ($privacy_data->settings->seo_enabled) ? 'IS' : 'IS NOT';
            }

            if (gettype($privacy_data->settings) === 'array') {
                $isOrIsNot = ($privacy_data->settings['seo_enabled']) ? 'IS' : 'IS NOT';
            }

            $statements = "Your profile is set to [PUBLIC]" .
                "Employers on PreviewMe who have received an application for an opportunity can view your profile. Employers who have not received an application for an opportunity on PreviewMe can only see the content you have made available for viewing and must request access to view any additional content directly with you." . 
                "People outside of PreviewMe [CAN] view your profile [(subject to your visibility restrictions[click to change]) only when you share your Profile URL Link [Public URL Inset] with those people]." .
                "Your Profile [' . $isOrIsNot . '] searchable on search engines [for Search Engine swtiched to ON include (eg: Google, FireFox, Microsoft Edge etc)]." . 
                "You can change any of these settings at anytime by clicking [HERE].";
        }

        return $statements;
    }

    /**
     * Return Formatted JSON Response
     *
     * @param [Boolean] $success
     * @param [String] $message
     * @param [Integer] $status
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($success, $message, $data, $status)
    {
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data], $status);
    }
}