<?php

namespace App\Repositories;

use Mail;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CompanyInterface;
use App\Models\Company;
use App\Models\CompanyFollower;
use App\Models\Country;
use App\Models\Job;
use App\Models\Team;
use App\Models\Industry;
use App\Models\PmUser;
use App\Models\TeamMember;
use App\Models\Employer;
use App\Models\Location;
use App\Validators\CompanyValidator;

/**
 * Class CompanyRepository.
 *
 * @package namespace App\Repositories;
 */
class CompanyRepository extends BaseRepository implements CompanyInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Company::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Fetches company information
     * 
     * @param [string] $company_url - Company URL
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInfoByUrl(string $company_url)
    {   
        $company = Company::where('e_company.company_url', '=', $company_url)
                    ->with('jobs.accountabilities')
                    ->with('jobs.requirements')
                    ->with('jobs.objectives')
                    ->with('jobs.company')
                    ->with('jobs.location')
                    ->with('location')
                    ->with('industry')
                    ->with('docs')
                    ->get();
        
        if (count($company) === 0) 
            return $this->response(false, 'Company does not exist', 404);
        
        $company[0]['followers'] = CompanyFollower::where('company_id', $company[0]['id'])->count();
        return $company;
        
    }

    /**
     * Fetches company information by id
     * 
     * @param [string] $company_id - Company Id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInfoById(string $company_id)
    {
        $company = Company::where('e_company.id', '=', $company_id)
                    ->with('jobs.accountabilities')
                    ->with('jobs.requirements')
                    ->with('jobs.objectives')
                    ->with('jobs.company')
                    ->with('jobs.location')
                    ->with('location')
                    ->with('industry')
                    ->with('docs')
                    ->get();

        if (count($company) === 0)
            return $this->response(false, 'Company does not exist', 404);

        $company[0]['followers'] = CompanyFollower::where('company_id', $company[0]['id'])->count();
        return $company;
    }

    /**
     * Updates company information
     * 
     * @param [object] $request - \App\Http\Requests\Employer\CompanyUpdateRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInfo($request)
    {   
        $company_id = $request->company_id;
        $validated = (object) $request->validated();

        $company = Company::find($company_id);

        $company_fields = [
                            'company_name',
                            'company_description',
                            'num_of_employees',
                            'status',
                            'logo_url', 
                            'website_url', 
                            'company_phone', 
                            'company_fax', 
                            'nz_business_num', 
                            'street_address', 
                            'street_address_2',
                            'company_url',
                            'company_banner_url',
                            'helper_text'
                        ];

        foreach ($company_fields as $field) 
            if (property_exists($validated, $field)) $company->$field = $validated->$field;

        if (!$company->save()) 
            return $this->response(false, 'Cannot update company information', 400);
        
        return $this->response(true, 'Company Information was successfully updated', 200);

    }

    /**
     * Get Company Employers
     * @param [string] $company_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployers(string $company_id)
    {
        $company_employers = Company::where('e_company.id', '=', $company_id)
                    ->with('employers')
                    ->with('employers.accountType')
                    ->with('employers.user')
                    ->get();

        if (count($company_employers) === 0) 
            return $this->response(false, 'No employer exist for this company', 404);

        return $company_employers;
    }
    
    /**
     * Get Company Teams
     *
     * @param [type] $request
     * @return Object
     */
    public function getTeams($request)
    {      
        $company_teams = [];
        $employer_id = $request->employer_id;
        
        // If Employer Is Company Admin
        if ($this->getCompanyRole($employer_id) === 5) {
            $company = Company::where('id', $request->company_id)
                            ->with('teams.members.employer.user')
                            ->with('teams.members.employer.company')
                            ->with('teams.members.employer.accountType')
                            ->first();
        
            $has_modify_access = $this->hasModifyPermission($employer_id);

            if ($company) {
                $teams = json_decode($company->teams);
                
                foreach ($teams as $t_key => $team) {
                    array_push($company_teams, [
                        "id" => $teams[$t_key]->id,
                        "team_name" => $teams[$t_key]->team_name,
                        "members" => [],
                        "permissions" => [
                            "modify" => $has_modify_access
                        ],
                        "modify" => $has_modify_access
                    ]);
                    
                    foreach ($teams[$t_key]->members as $m_key => $member) {

                        $account_type_string = "";
                        if ($member->employer->account_type_id === 5) {
                            $account_type_string = "Company Admin";
                        } elseif ($member->employer->account_type_id === 6) {
                            $account_type_string = "Company Member";
                        } else {
                            $account_type_string = "Company Job Manager";
                        }

                        array_push($company_teams[$t_key]['members'], [
                            "team_role" => $member->team_role,
                            "employer" => [
                                "account_type_string" => $account_type_string,
                                "id" => $member->employer->id,
                                "first_name" => $member->employer->user->first_name,
                                "last_name" => $member->employer->user->last_name,
                                "email" => $member->employer->user->email,
                                "nickname" => $member->employer->nickname,
                                "phone_number" => $member->employer->phone_number,
                                "phone_extension" => $member->employer->phone_extension,
                                "mobile_number" => $member->employer->mobile_number,
                                "work_title" => $member->employer->work_title,
                                "work_dept" => $member->employer->work_dept,
                                "profile_picture_url" => $member->employer->profile_picture_url,
                                "azure_container_key" => $member->employer->company->ob_key . "/" . $member->employer->user->ob_key
                            ]
                        ]);
                    }

                }
                return $company_teams;
            }
        }
        
        // If Employer is Company Member
        $employer_teams = [];
        $employer = Employer::where('id', $employer_id)
                            ->with('teams')
                            ->first();            
        
        if (count($employer->teams) > 0) {
            $teams = $employer->teams;

            foreach ($teams as $team_key => $team_value) 
                array_push($employer_teams, $teams[$team_key]->team_id);

            $company = Company::where('id', $request->company_id)
                                ->with(['teams' => function($q) use($employer_teams) {
                                    $q->whereIn('id', $employer_teams);
                                    $q->with('members.employer.user');
                                    $q->with('members.employer.company');
                                    $q->with('members.employer.accountType');
                                }])
                                ->first();

            $has_modify_access = $this->hasModifyPermission($employer_id);

            if ($company) {
                $teams = json_decode($company->teams);
                
                foreach ($teams as $t_key => $team) {
                    array_push($company_teams, [
                        "id" => $teams[$t_key]->id,
                        "team_name" => $teams[$t_key]->team_name,
                        "members" => [],
                        "permissions" => [
                            "modify" => $has_modify_access
                        ],
                        "modify" => $has_modify_access
                    ]);
                                        
                    foreach ($teams[$t_key]->members as $m_key => $member) {
                        $account_type_string = "";
                        if ($member->employer->account_type_id === 5) {
                            $account_type_string = "Company Admin";
                        } elseif ($member->employer->account_type_id === 6) {
                            $account_type_string = "Company Member";
                        } else {
                            $account_type_string = "Company Job Manager";
                        }
                    
                        array_push($company_teams[$t_key]['members'], [
                            "team_role" => $member->team_role,
                            "employer" => [
                                "account_type_string" => $account_type_string,
                                "id" => $member->employer->id,
                                "first_name" => $member->employer->user->first_name,
                                "last_name" => $member->employer->user->last_name,
                                "email" => $member->employer->user->email,
                                "nickname" => $member->employer->nickname,
                                "phone_number" => $member->employer->phone_number,
                                "phone_extension" => $member->employer->phone_extension,
                                "mobile_number" => $member->employer->mobile_number,
                                "work_title" => $member->employer->work_title,
                                "work_dept" => $member->employer->work_dept,
                                "profile_picture_url" => $member->employer->profile_picture_url,
                                "azure_container_key" => $member->employer->company->ob_key . "/" . $member->employer->user->ob_key
                            ]
                        ]);
                    }
                    
                }
                return $company_teams;
            }

        }

    }
    
    /**
     * Get Company Team Members
     *
     * @param [type] $request
     * @return Object
     */
    public function getTeamMembers($request)
    {   
        $company_members = [];
        $company = Company::where('id', $request->company_id)
                            ->with('teams.members.employer.user')
                            ->with('teams.members.employer.company')
                            ->with('teams.members.employer.accountType')
                            ->first();
        
        if ($company) {
            $teams = json_decode($company->teams);
            
            foreach ($teams as $t_key => $team) {
                foreach ($teams[$t_key]->members as $m_key => $member) {

                    $account_type_string = "";
                    if ($member->employer->account_type_id === 5) {
                        $account_type_string = "Company Admin";
                    } elseif ($member->employer->account_type_id === 6) {
                        $account_type_string = "Company Member";
                    } else {
                        $account_type_string = "Company Job Manager";
                    }

                    array_push($company_members, [
                        "account_type_string" => $account_type_string,
                        "id" => $member->employer->id,
                        "first_name" => $member->employer->user->first_name,
                        "last_name" => $member->employer->user->last_name,
                        "email" => $member->employer->user->email,
                        "nickname" => $member->employer->nickname,
                        "phone_number" => $member->employer->phone_number,
                        "phone_extension" => $member->employer->phone_extension,
                        "mobile_number" => $member->employer->mobile_number,
                        "work_title" => $member->employer->work_title,
                        "work_dept" => $member->employer->work_dept,
                        "profile_picture_url" => $member->employer->profile_picture_url,
                        "azure_container_key" => $member->employer->company->ob_key . "/" . $member->employer->user->ob_key
                    ]);
                }

            }

            return $company_members;
        }

    }

    /**
     * Create Company Team
     *
     * @param [type] $request
     * @return void
     */
    public function storeTeam($request)
    {   
        if ($request->all()) {
            
            $new_team = new Team;
            $validated = (object) $request->validated();
            $team_fields = [
                'team_name',
                'created_by_id',
                'company_id'
            ];

            foreach ($team_fields as $field) 
                if (property_exists($validated, $field)) $new_team->$field = $validated->$field;

            $new_team->recorded_date = date('Y-m-d H:i:s');

            if ($new_team->save()) {
                $this->storeCompanyTeamAdmin($request->team_admin, $new_team->id);
                $this->storeCompanyTeamMembers($request->members, $new_team->id);

                return $this->response(true, 'New Team was successfully created!', 200);
            }

            return $this->response(false, 'Failed to create Company Team', 400);
        }
        
    }

    /**
     * Update Company Team
     *
     * @param [type] $request
     * @return void
     */
    public function updateTeam($request)
    {   
        if ($request->all()) {
            
            $team = Team::where('id', $request->team_id)->first();
            $validated = (object) $request->validated();
            $team_fields = [
                'team_name',
                'created_by_id',
                'company_id'
            ];

            foreach ($team_fields as $field)
                if (property_exists($validated, $field)) $team->$field = $validated->$field;

            $team->recorded_date = date('Y-m-d H:i:s');

            if ($team->save()) {
                $this->updateCompanyTeamAdmin($request->team_admin, $team->id);
                $this->updateCompanyTeamMembers($request->members, $team->id);

                return $this->response(true, 'Team was successfully updated!', 200);
            }

            return $this->response(false, 'Failed to update Company Team', 400);
        }
        
    }

    /**
     * Store Company Team Admin
     *
     * @param [type] $id
     * @return void
     */
    private function storeCompanyTeamAdmin($team_admin_id, $last_inserted_id)
    {
        if ($team_admin_id != null) {
            $new_team_admin = new TeamMember;
            $new_team_admin->team_id = $last_inserted_id;
            $new_team_admin->team_role = "team_admin";
            $new_team_admin->recorded_date = date('Y-m-d H:i:s');
            $new_team_admin->employer_id = $team_admin_id;
            $new_team_admin->save();
        }
    }

    /**
     * Udpate Company Team Admin
     *
     * @param [type] $id
     * @return void
     */
    private function updateCompanyTeamAdmin($team_admin_id, $team_id)
    {
        if ($team_admin_id != null) {
            $team_admin = TeamMember::where('team_id', $team_id)->first();
            $team_admin->employer_id = $team_admin_id;
            $team_admin->save();
        }
    }

    /**
     * Store Company Team Members
     *
     * @return void
     */
    private function storeCompanyTeamMembers($members, $last_inserted_id)
    {
        if (count($members) > 0) {
            $team_members = $members;
            foreach ($team_members as $member) {
                $new_team_member = new TeamMember;
                $new_team_member->team_id = $last_inserted_id;
                $new_team_member->team_role = "team_member";
                $new_team_member->recorded_date = date('Y-m-d H:i:s');
                $new_team_member->employer_id = $member;
                $new_team_member->save();
            }
        }
    }

    /**
     * Update Company Team Members
     *
     * @return void
     */
    private function updateCompanyTeamMembers($members, $team_id)
    {
        if (count($members) > 0) {
            $team_members = $members;
            foreach ($team_members as $member) {
                $team_member = TeamMember::where('team_id', $team_id)
                                        ->where('team_role', 'team_member')
                                        ->first();
                if ($team_member)
                    $team_member->delete();
            }
            $this->storeCompanyTeamMembers($members, $team_id);
        }
    }

    /**
     * Delete Company Team
     *
     * @param [type] $request
     * @return Object
     */
    public function destroyTeam($request)
    {   
        $team = Team::where('id', $request->team_id);
        if ($team->delete()) 
            return $this->response(true, 'Company Team was successfully deleted!', 200);

        return $this->response(false, 'Failed to delete Company Team', 400);
    }

    /**
     * Delete Company Team Member
     *
     * @param [type] $request
     * @return Object
     */
    public function destroyTeamMember($request)
    {  
        $team_member = TeamMember::where('team_id', $request->team_id)
                                ->where('employer_id', $request->employer_id);
        if ($team_member->delete()) 
            return $this->response(true, 'Team Member was successfully deleted!', 200);

        return $this->response(false, 'Failed to delete Team Member', 400);
    }

    /**
     * Store Invited Company Team Member
     *
     * @param [type] $request
     * @return Object
     */
    public function storeInvitedTeamMember($request)
    {   
        $user = new PmUser;
        $validated = (object) $request->validated();
        $user_fields = [
            'first_name',
            'last_name',
            'email'
        ];

        foreach ($user_fields as $field)
            if (property_exists($validated, $field)) $user->$field = $validated->$field;

        $user->username = $validated->email;
        $user->username_canonical = $validated->email;
        $user->email_canonical = $validated->email;
        $user->user_type = "employer";

        if ($user->save()) {
            $employer = new Employer;
            $employer->user_id = $user->id;
            $employer->company_id = $request->company_id;
            $employer->account_type_id = 6; // Default to Company Member
            $employer->recorded_date = date('Y-m-d H:i:s');
            $employer->save();
        
            $employer_info = Employer::where('id', $employer->id)
                    ->with('company')
                    ->with('user')
                    ->first();

            $account_type_string = '';
            if ($employer_info->account_type_id === 5) {
                $account_type_string = "Company Admin";
            } elseif ($employer_info->account_type_id === 6) {
                $account_type_string = "Company Member";
            } else {
                $account_type_string = "Company Job Manager";
            }

            $employer_data = [
                "account_type_string" => $account_type_string,
                "id" => $employer_info->id,
                "first_name" => $employer_info->user->first_name,
                "last_name" => $employer_info->user->last_name,
                "email" => $employer_info->user->email,
                "nickname" => $employer_info->nickname,
                "phone_number" => $employer_info->phone_number,
                "phone_extension" => $employer_info->phone_extension,
                "mobile_number" => $employer_info->mobile_number,
                "work_title" => $employer_info->work_title,
                "work_dept" => $employer_info->work_dept,
                "profile_picture_url" => $employer_info->profile_picture_url,
                "azure_container_key" => $employer_info->company->ob_key . "/" . $employer_info->user->ob_key
            ];

            $subject = 'PreviewMe - You have been invited to company';
            $to = $validated->email;
            Mail::send('email.invite-team-member', ['first_name' => $employer_info->user->first_name, 'company_name' => $employer_info->company->company_name], 
                function ($message) use ($subject, $to) {
                    $message->subject($subject);
                    $message->from(getenv('MANDRILL_ADDRESS', 'PreviewMe'));
                    $message->to($to);
                });

            return $employer_data;

        }

    }

    /**
     * Check if it has a Permission to Modify
     *
     * @param [string] $employer_id
     * @return boolean
     */
    private function hasModifyPermission($employer_id)
    {   
        $can_modify = false;
        $employer = Employer::where('id', $employer_id)
                            ->with('permissions.permission')
                            ->first();

        if ($employer) {
            $permissions = json_decode($employer->permissions);

            foreach ($permissions as $perm_key => $perm_value)
                if ($permissions[$perm_key]->permission->id === 64) $can_modify = true;
        }

        return $can_modify;
    }

    /**
     * Get Company Role
     *
     * @param [type] $employer_id
     * @return void
     */
    private function getCompanyRole($employer_id)
    {
        $employer = Employer::where('id', $employer_id)
                                ->first();
        $role = $employer->account_type_id;
        return $role;
    }

    /**
     * Filter Companies.
     *
     * @param [array] $search
     * @return \Illuminate\Http\Response
     */
    public function filterCompanies(array $search = []) 
    {
        $company = Company::with('jobs.accountabilities')
                    ->with('jobs.requirements')
                    ->with('jobs.objectives')
                    ->with('jobs.company')
                    ->with('jobs.location')
                    ->with('location')
                    ->with('industry')
                    ->with('docs')
                    ->with('doc_video');

        if($search['q'])
            $company->likeCompanyName($search['q']);

        if($search['industry']) {
            $selected_industries = explode(",",$search['industry']);
            $industries = Industry::whereIn('parent_id', $selected_industries)->pluck('id');
            $company->whereIn('industry_id', $industries);
        }

        if($search['sub_industry']) {
            $selected_sub_industries = explode(",",$search['sub_industry']);
            $company->whereIn('industry_id', $selected_sub_industries);
        }

        if($search['location']) {
            $location_ids = Location::where('display_name', 'like', '%' . $search['location'] . '%')->pluck('id');
            $company->whereIn('location_id', $location_ids);
        }

        if($search['country']) {
            $selected_country = Country::where('codeSlugName', $search['country'])->first();
            $location_ids = Location::where('country_id', $selected_country->id)->pluck('id');
            $company->whereIn('location_id', $location_ids);
        }
        
        return $company->paginate(10);
    }

    /**
     * Get All Active Companies
     *
     * @return \Illuminate\Http\Response
     */
    public function getActiveCompanies()
    {
        return Company::where('status', 'active')->get();
    }
    
    /**
     * Return Formatted JSON Response
     *
     * @param [Boolean] $success
     * @param [String] $message
     * @param [Integer] $status
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($success, $message, $status)
    {
        return response()->json(['success' => $success, 'message' => $message], $status);
    }

}
