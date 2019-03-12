<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CandidateProfileCompletion;
use DB;
use App\Models\Candidate;

class CandidateDocs extends Model implements CandidateProfileCompletion
{
    const ICEBREAKER_VIDEO = 'icebreaker_video';
    const PROFILE_IMAGE = 'profile_image';

    protected $table = 'c_docs';

    public static function completionProgress() : array
    {
        $candidate = Candidate::latest()->first();
        $icebreakerVideo = self::select(['doc_type', 'doc_url'])
            ->where([
                ['candidate_id', $candidate->id],
                ['doc_type', self::ICEBREAKER_VIDEO]
            ])
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();
        
        $profileImage = self::select(['doc_type', 'doc_url'])
            ->where([
                ['candidate_id', $candidate->id],
                ['doc_type', self::PROFILE_IMAGE]
            ])
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        return [$icebreakerVideo, $profileImage];
    }

    /**
     * Get document type
     *
     * @return array
     */
    public static function getDocTypes() : array
    {
        return [self::ICEBREAKER_VIDEO, self::PROFILE_IMAGE];
    }
}
