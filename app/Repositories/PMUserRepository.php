<?php

namespace App\Repositories;

use App\Repositories\Contracts\PMUserInterface;
use App\Models\PmUser;
use App\Models\Industry;
use App\Models\Country;
use App\Models\Location;
use App\Models\Candidate;
use App\Models\CandidateDocs;
use App\Services\LocationService;
use App\Services\IndustryService;
use App\Services\WorkHistoryService;
use App\Services\CandidateDocService;

/**
 * Class PMUserRepository.
 *
 * @package namespace App\Repositories;
 */
class PMUserRepository implements PMUserInterface
{
    private $locationServ;
    private $industryServ;
    private $workHistoryServ;
    private $candidateDocServ;

    public function __construct(LocationService $locationServ, IndustryService $industryServ, WorkHistoryService $workHistoryServ, CandidateDocService $candidateDocServ)
    {
        $this->locationServ = $locationServ;
        $this->industryServ = $industryServ;
        $this->workHistoryServ = $workHistoryServ;
        $this->candidateDocServ = $candidateDocServ;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PmUser::class;
    }

    /**
     * Check if user id exist
     *
     * @return string
     */
    public function checkIdExist($id)
    {
        $response = false;

        if(!empty($id)) {
            $user = PmUser::find($id);
            if(isset($user['id'])) {
                $response = true;
            }
        }

        return $response;
    }

    /**
     * Display data from database
     *
     * @param int $id
     * @return array
     */
    public function getDetails($id)
    {
        $pmUser = PmUser::where('id', $id)
                    ->with('candidate')
                    ->with('candidate.preferredLocation')
                    ->with('candidate.workType')
                    ->with('candidate.industry')
                    ->with('candidate.nationality')
                    ->with('candidate.qualifications')
                    ->with('candidate.qualifications.qualification')
                    ->with('candidate.qualifications.qualificationProvider')
                    ->with('candidate.workHistory')
                    ->with('candidate.workHistory.work_type')
                    ->with('candidate.workHistory.work_history_industry')
                    ->with('candidate.reference')
                    ->with('candidate.docs')
                    ->first();
        if(!$pmUser) {
            return false;
        }
        $pmUser = $pmUser->toArray();

        //recreate preferred location array
        $pmUser['preferred_location'] = [];
        if(isset($pmUser['candidate']['preferred_location']['id'])) {
            $pmUser['preferred_location'] = $this->locationServ->formatPreferredLocationArr($pmUser['candidate']['preferred_location']);
        }

        //recreate industry array
        $pmUser['industry'] = [];
        if(isset($pmUser['candidate']['industry']['id'])) {
            $pmUser['industry'] = $this->industryServ->formatIndustryArr($pmUser['candidate']['industry']);
        }

        //recreate work history array
        $pmUser['work_history'] = [];
        if(isset($pmUser['candidate']['work_history'])) {
            $pmUser['work_history'] = $this->workHistoryServ->formatWorkHistoryArr($pmUser['candidate']['work_history']);
        }

        //recreate candidate docs
        $pmUser['docs'] = [];
        if(isset($pmUser['candidate']['docs'])) {
            $pmUser['docs'] = $this->candidateDocServ->formatDocsArr($pmUser['candidate']['docs']);
        }


        //recreate array
        $pmUser['phone_number'] = $pmUser['candidate']['phone_number'];
        $pmUser['mobile_number'] = $pmUser['candidate']['mobile_number'];
        $pmUser['nickname'] = $pmUser['candidate']['nickname'];
        $pmUser['profile_url'] = $pmUser['candidate']['profile_url'];
        $pmUser['long_description'] = $pmUser['candidate']['long_description'];
        
        $pmUser['min_salary'] = $pmUser['candidate']['min_salary'];
        $pmUser['max_salary'] = $pmUser['candidate']['max_salary'];

        $pmUser['nationality'] = $pmUser['candidate']['nationality'];
        $pmUser['work_type'] = $pmUser['candidate']['work_type'];
        $pmUser['qualifications'] = $pmUser['candidate']['qualifications'];
        $pmUser['references'] = $pmUser['candidate']['reference'];

        //get courses
        $pmUser['courses'] = [];

        //get language
        $pmUser['languages'] = [];

        //unset candidate arrray
        unset($pmUser['candidate']);

        return $pmUser;
    }

    /**
     * Update data in database
     *
     * @param array $data
     * @param int $id
     * @return array
     */
    public function updateName($data, $id)
    {
        // update on pm_user table
        $user = PmUser::find($id);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->save();

        // update on candaidate table
        $canditate = Candidate::where('user_id',$id)->update(['nickname'=>$data['nickname']]);

        return true;
    }

    /**
     * Update data in database
     *
     * @param array $data
     * @param int $id
     * @return array
     */
    public function updateByPMUserId($data, $pmUserId)
    {   
        $fillable = ['username', 'username_canonical', 'email', 'email_canonical', 'enabled', 'salt', 'password',
                     'last_login', 'confirmation_token', 'password_requested_at', 'roles', 'first_name', 'last_name',
                     'user_type', 'ob_key', 'aa_token'];
        $column = [];
        foreach ($data as $key => $value) {
            if(in_array($key, $fillable))
                $column[$key] = $value;
        }

        // update on `pm_user` table
        $canditate = PmUser::where('id',$pmUserId)->update($column);

        return true;
    }    

}
