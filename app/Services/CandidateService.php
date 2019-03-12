<?php

namespace App\Services;

use App\Repositories\Contracts\PrivacyInterface;
use App\Repositories\Contracts\CandidateInterface;
use App\Repositories\Contracts\CandidateDocsInterface;
use App\Criteria\Candidate\WithDocsCriteria;
use App\Criteria\WithPmUserCriteria;
use App\Criteria\WithPrivacyCriteria;
use App\Models\CandidateQualification;
use App\Models\CandidateWorkhistory;
use App\Models\CandidateDocs;
use App\Models\Candidate;

class CandidateService
{
    private $candidate;
    private $privacy;
    private $candidateDocs;

    public function __construct(CandidateInterface $candidate, PrivacyInterface $privacy, CandidateDocsInterface $candidateDocs)
    {
        $this->candidate = $candidate;
        $this->privacy = $privacy;
        $this->candidateDocs = $candidateDocs;
    }

    public function getCompletionProgress() : array
    {
        [$profileVideo, $profileImage] = CandidateDocs::completionProgress();
        $education = CandidateQualification::completionProgress();
        $experience = CandidateWorkhistory::completionProgress();

        $results = [];

        $results[$profileVideo["doc_type"]] = $profileVideo ? true : false;
        $results[$profileImage["doc_type"]] = $profileImage ? true : false;
        $results["experience"] = !empty($experience);
        $results["education"] = !empty($education);

        $total = 4;
        $progress = 0;
        foreach ($results as $result) {
            if ($result) {
                $progress += 1;
            }
        }
        $results["completion"] = round(($progress / $total) * 100);
        $results["profile_video"] = $profileVideo ? $profileVideo["doc_url"] : null;

        return $results;
    }
    
    public function getCandidatePrivacy() : object
    {
        $candidate = Candidate::latest()->first();
        return $this->privacy->findWhere(['candidate_id' => $candidate->id], ['settings', 'type'])->first();
    }

    public function getCandidateInfo() : object
    {
        $candidate = Candidate::latest()->first();
        $this->candidate->pushCriteria(new WithPmUserCriteria('candidate.user_id'));
        
        $cols = [
            'pm_user.first_name',
            'pm_user.last_name',
            'pm_user.email',
            'candidate.long_description',
        ];

        /**
         * Do not filter the record by doc_type = 'profile_image'
         * Candidate's registration does not require image upload.
         */
        $candidateInfo = $this->candidate->scopeQuery(function ($query) use ($candidate) {
            return $query->where([
                ['candidate.id', $candidate->id],
            ]);
        })->first($cols);

        $candidateInfo["profile_image"] = $this->candidateDocs->scopeQuery(function ($query) use ($candidate) {
            return $query->where(['candidate_id' => $candidate->id, 'doc_type' => CandidateDocs::PROFILE_IMAGE]);
        })->orderBy('id', 'desc')->first()->doc_url;
                                                              
        return $candidateInfo;
    }
}
