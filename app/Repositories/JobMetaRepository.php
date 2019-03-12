<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Contracts\JobMetaInterface;
use App\Models\JobMeta;
use App\Models\CandidateDocs;
use App\Models\CandidateReference;
use App\Models\CandidateQualification;
use App\Models\CandidateWorkhistory;
use App\Models\Language;

/**
 * Class JobRepository.
 *
 * @package namespace App\Repositories;
 */
class JobMetaRepository implements JobMetaInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return JobMeta::class;
    }

    /**
     * function check if candidate has...has_what can be anything related to candidate
     * currently used by the application service in requirement check function
     * @param string $candidateId
     * @param string $requirement
     * @return bool
     */
    public function candidateHas($candidateId, $requirement)
    {
        
        // codes based on pvm-api\src\CandidateBundle\Services\CandidateManager.php LINE 549

        $maybe_he_has = false;

        $candidate = Candidate::find($candidateId)->first();

        if( in_array( $requirement, array('icebreaker_video', 'portfolio', 'resume', 'profile_image', 'cover_letter', 'transcript') )){

            $cDocs = CandidateDocs::where('candidate_id', $candidateId)
                                    ->where('doc_type', $requirement)
                                    ->first();

            if(isset($cDocs['id'])) {
                $maybe_he_has = true;
            }

        }

        if( $requirement == 'references' ){

            $cReference = CandidateReference::where('candidate_id', $candidateId)->first();

            if(isset($cReference['id'])) {
                $maybe_he_has = true;
            }

        }

        if( $requirement == 'about_me' ) {

            if(!empty($candidate['long_description'])) {
                $maybe_he_has = true;
            }

        }

        if( $requirement == 'education' ) {
            
            $cQualification = CandidateQualification::where('candidate_id', $candidateId)->first();

            if(isset($cQualification['id'])) {
                $maybe_he_has = true;
            }

        }

        if( $requirement == 'work_experience' ) {

            $cWorkhistory = CandidateWorkhistory::where('candidate_id', $candidateId)->first();

            if(isset($cWorkhistory['id'])) {
                $maybe_he_has = true;
            }

            if($candidate['new_to_workforce'] == 1) {
                $maybe_he_has = true;
            }

        }

        if( $requirement == 'phone_number' ) {

            if(!empty($candidate['phone_number'])) {
                $maybe_he_has = true;
            }

        }

        if( $requirement == 'language' ) {

            $language = Language::where('candidate_id', $candidateId)->first();

            if(isset($language['id'])) {
                $maybe_he_has = true;
            }

        }

        return $maybe_he_has;
    }

    /**
     * Get _application_requirements of the Job Meta
     *
     * @param [string] $jobId
     * @param [string] $candidateId
     * @return array
     */
    public function getRequirementsCheck($jobId, $candidateId) 
    {
        // codes based on pvm-api\src\CandidateBundle\Services\JobApplicationService.php LINE 599
        
        $jobMeta = JobMeta::where('job_id', $jobId)->get();

        $applicationRequirements = "";
        foreach ($jobMeta as $key => $value) {
            if($value['meta_key'] == '_application_requirements') {
                $applicationRequirements = json_decode($value['meta_value'], true);
            }
        }

        $results = [];
        if(!empty($applicationRequirements)) {
            return $applicationRequirements;
            foreach( $applicationRequirements as  $requirement => $required ){
                if( $required == 'yes' ){
                    $result = $this->candidateHas($candidateId, $requirement);
                    if( false == $result ){
                        $results[] = $requirement;
                    }
                }
            }
        }

        return $results;
    }

}
