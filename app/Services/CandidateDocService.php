<?php

namespace App\Services;

use App\Models\Industry;

class CandidateDocService
{

    /**
     * recreate candidate docs array
     *
     * @return array
     */
    public function formatDocsArr($docs): array
    {
        $data = array();

        $data['profile_image'] = [];
        $data['icebreaker_video'] = []; 
        $data['resume'] = []; 
        $data['portfolio'] = []; 
        $data['transcript'] = []; 
        $data['cover_letter'] = []; 

        foreach ($docs as $key => $value) {
            $data[$value['doc_type']] = $value['doc_url'];
        }

        return $data;
    }
    
}
