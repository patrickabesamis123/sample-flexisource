<?php

namespace App\Services;

use App\Repositories\Contracts\JobInterface;
use App\Repositories\Contracts\TeamsMembersInterface;
use App\Repositories\Contracts\CandidateJobApplicationInterface;
use App\Models\Job;
use App\Models\TeamsMembers;
use App\Models\CandidateJobApplication;
use App\Criteria\WithLocationCriteria;
use App\Criteria\WithCountryCriteria;
use App\Criteria\WithEmployerCriteria;
use App\Criteria\WithPmUserCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobService
{
    private $job;

    private $teams_members;

    private $candidate_job_app;

    /**
     * Constructor setup
     *
     * @param JobInterface $job
     * @param CompanyInterface $company
     */
    public function __construct(JobInterface $job, TeamsMembersInterface $teams_members, CandidateJobApplication $candidate_job_app)
    {
        $this->job               = $job;
        $this->teams_members     = $teams_members;
        $this->candidate_job_app = $candidate_job_app;
    }

    /**
     * Fetches jobs for each status
     *
     * @return void
     */
    public function getCompanyRoles($company_id, $status){
        $company_details = $this->getCompanyDetails($company_id, $status);
        $other_teams = $this->getOtherTeams($company_id, $status);

        $other_team_members = array();
        foreach($other_teams as $other_team){
            $other_team_members[] = $this->getOtherMembers($other_team->id);
        }

        $job_ctr = count($company_details);
        for($i = 0; $i < $job_ctr; $i++){
            $company_details[$i]['total_applicants']    = $this->getCandidatesApplied($company_details[$i]['id'], true);
            $company_details[$i]['failed_pre_approval'] = $this->getCandidatesFailedPreApply($company_details[$i]['id'], true);
        }
       
        $company_vals = array("company_details"  => $company_details,
                            "other_teams"        => $other_teams,
                            "other_team_members" => $other_team_members);

        return $company_vals;

    }

    public function getCompanyDetails($company_id, $status){
        $query = "SELECT jj.id, job_title, object_id, closing_date, 
                        CASE WHEN expiry_date < CURDATE() THEN true
                        ELSE false END AS is_job_expired, 
                        l.display_name AS location, c.displayName AS country, expiry_date, closed_date, job_description,
                        CONCAT(pu.first_name, ' ', pu.last_name) AS creator, CONCAT(pu2.first_name, ' ', pu2.last_name) AS manager, 
                        jj.published_date AS date_created, jj.job_closing_reason, jj.auto_close, jj.auto_expire, 
                        CASE WHEN expiry_date < CURDATE() THEN 0
                        ELSE DATEDIFF(expiry_date, CURDATE()) END AS expiry_days_left, 
                        CASE WHEN closed_date IS NOT NULL THEN 0
                        ELSE DATEDIFF(closing_date, CURDATE()) END AS closing_days_left
                FROM j_job AS jj
                LEFT JOIN location AS l
                ON jj.location_id = l.id
                LEFT JOIN country AS c
                ON l.country_id = c.id
                LEFT JOIN e_employer AS ee
                ON jj.created_by_id = ee.id
                LEFT JOIN pm_user AS pu
                ON ee.user_id = pu.id
                    LEFT JOIN e_employer AS ee2
                    ON jj.job_manager_id = ee2.id
                    LEFT JOIN pm_user AS pu2
                    ON ee2.user_id = pu2.id
                WHERE jj.company_id = '" . $company_id . "'
                AND jj.job_status = '" . $status . "'";

        return json_decode(json_encode(DB::select($query)), true);

    }

    public function getOtherTeams($company_id){
        return DB::table('e_teams')
                ->select('*')
                ->where('company_id', $company_id)
                ->get();

    }

    public function getOtherMembers($team_id){
        $this->teams_members->pushCriteria(new WithEmployerCriteria('e_teams_members.employer_id'));
        $this->teams_members->pushCriteria(new WithPmUserCriteria('e_employer.user_id'));

        $cols = [
            'pm_user.first_name', 'pm_user.last_name', 'e_employer.profile_picture_url'
        ];

        return $this->teams_members
                    ->findWhere(array("e_teams_members.team_id" => $team_id), $cols);

    }

    public function getCandidatesApplied($job_id, $count_flag = false){
        // get list of candidates
        $candidate_list = $this->candidate_job_app
                                ->where('job_id', $job_id)
                                ->get();

        // check if return raw list of candidates or just the count
        if($count_flag){
            return count($candidate_list);
        }else{
            return $candidate_list;
        }

    }

    public function getCandidatesFailedPreApply($job_id, $count_flag = false){
        // get list of candidates
        $candidate_failed = $this->candidate_job_app
                                ->where('job_id', $job_id)
                                ->where('app_steps', 'LIKE', '%"pre_apply_questions":"failed"%')
                                ->get();

        // check if return raw list of candidates or just the count
        if($count_flag){
            return count($candidate_failed);
        }else{
            return $candidate_failed;
        }
    }

}
