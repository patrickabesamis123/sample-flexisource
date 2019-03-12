<?php

namespace App\Repositories;

use Hash, Mail;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\EmployerInterface;
use App\Models\Employer;
use App\Models\Integration;
use App\Models\Job;
use App\Models\Country;
use App\Models\PmUser;
use App\Models\JobDefaultWorkflowStep;
use App\Models\JobWorkflowProgress;
use App\Models\CandidateJobApplication;
use App\Models\Company;
use App\Models\EmployerDoc;
use App\Models\EmployerCandidateWatchlist;

/**
 * Class EmployerRepository.
 *
 * @package namespace App\Repositories;
 */
class EmployerRepository extends BaseRepository implements EmployerInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Employer::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * Get employer id
     */
    public function getEmployerId($user_id)
    {
        $employer_id = Employer::where('user_id', $user_id)->select('id')->first();
        $employer_id = json_decode($employer_id);
        return $employer_id->id;
    }


    /**
     * Get user id
     */
    public function getUserId($employer_id)
    {
        $user_id = Employer::where('id', $employer_id)->select('user_id')->first();
        $user_id = json_decode($user_id);
        return $user_id->user_id;
    }

    /**
     * Get Employer Information
     *
     * @param [string] $employer_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInfoById(string $employer_id)
    {   
        $employers = Employer::where('id', $employer_id)
                    ->with('accountType')
                    ->with('company')
                    ->with('company.industry')
                    ->with('company.location')
                    ->with('company.location.country')
                    ->with('company.docs')
                    ->with('user')
                    ->get();

        if (count($employers) === 0) return $this->response(false, 'Error Listing', null, 400);
        return $employers;

    }

    /**
     * Update Employers Email Address
     *
     * @param [object] $request - \App\Http\Requests\Employer\UpdateEmailRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail($request)
    {   
        $employer_email = '';
        $employer_id = $request->employer_id;
        $employer = Employer::find($employer_id);

        if ($employer) {
            $validated = (object) $request->validated();
            if (property_exists($validated, 'email')) $employer_email = $validated->email;
            if (!$this->checkEmailIfExist($employer_email)) {
                $user = PmUser::find($employer->user_id);
                $user->email = $employer_email;
                $user->email_canonical = $employer_email;
                if (!$user->save()) 
                    return $this->response(false, 'Cannot update employer email address', null, 400);

                return $this->response(true, 'Employer email address was successfully updated!', null, 200);
            }
            return $this->response(false, 'Email address already exists', null, 409);
        }
        
    }

    /**
     * Update Employers Password
     *
     * @param [object] $request - \App\Http\Requests\Employer\UpdatePasswordRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword($request)
    {   
        $employer_password = '';
        $employer_id = $request->employer_id;
        $employer = Employer::find($employer_id);
        
        if ($employer) {
            if ($this->checkifPasswordMatch($request->user_id, $request->current_password)) {
                $validated = (object) $request->validated();
                if (property_exists($validated, 'password')) $employer_password = $validated->password;
                
                $user = PmUser::find($employer->user_id);
                $user->password = Hash::make($employer_password);

                if (!$user->save()) return $this->response(false, 'Cannot update employer password', null, 400);
                return $this->response(true, 'Employer password was successfully updated!', null, 200);
            }
            return $this->response(false, 'Current Password does not match', null, 409);
        }
    }
    
    /**
     * Update Employers Basic Information
     *
     * @param [object] $request - \App\Http\Requests\Employer\UpdateBasicInformationRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBasicInfo($request)
    {
        $employer_id = $request->employer_id;
        $employer = Employer::find($employer_id);
        
        if ($employer) {
            $validated = (object) $request->validated();
            $employer_fields = [
                'nickname',
                'phone_number',
                'mobile_number',
                'work_title',
                'work_dept'
            ];

            foreach ($employer_fields as $field)
                if (property_exists($validated, $field)) $employer->$field = $validated->$field;

            $user = PmUser::find($employer->user_id);
            $user_fields = [
                'first_name',
                'last_name'
            ];

            foreach ($user_fields as $field)
                if (property_exists($validated, $field)) $user->$field = $validated->$field;

            if (!$employer->save() || !$user->save()) return $this->response(false, 'Cannot update employer information', null, 400);
            return $this->response(true, 'Employer Information was successfully updated', null, 200);
        }
    }

    /**
     * Update Employers Account Type
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAccountType($request)
    {
        $employer_id = $request->employer_id;
        $employer = Employer::find($employer_id);
        
        if ($employer) {
            $employer->account_type_id = $request->account_type;
            if (!$employer->save()) return $this->response(false, 'Cannot update employer account type', null, 400);
            return $this->response(true, 'Employer account type was successfully updated', null, 200);
        }
    }

    /**
     * Update Employers Account Status
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAccountStatus($request)
    {
        $employer_id = $request->employer_id;
        $employer = Employer::find($employer_id);
        
        if ($employer) {
            $user = PmUser::find($employer->user_id);
            $user->enabled = 0;

            if (!$user->save()) return $this->response(false, 'Cannot update employer account status', null, 400);
            return $this->response(true, 'Employer account status was successfully updated', null, 200);
        }
    }

    /**
     * Add Javascript Integration Request
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeJsIntegrationRequest($request)
    {
        $employer_id = $request->employer_id;
        $employer = Employer::find($employer_id);
        
        if ($employer) {
            if (!$this->checkIfIntegrationExist($employer->company_id)) {

                $default_config = '{"layout":{"column":1},"job_title":{"color":"#00aeed","family":"Montserrat","family_file":{"family":"Montserrat","file":"http://fonts.gstatic.com/s/montserrat/v12/JTUSjIg1_i6t8kCHKm45xW4.ttf"},"size":"16px"},"job_desc":{"color":"#5a5a5a","family":"Montserrat","family_file":{"family":"Montserrat","file":"http://fonts.gstatic.com/s/montserrat/v12/JTUSjIg1_i6t8kCHKm45xW4.ttf"},"size":"13px"},"video":true,"logo":true,"groupings":"none"}';

                $integration = new Integration;
                $integration->company_id = $employer->company_id;
                $integration->requested_by_id = $employer->id;
                $integration->isAccessRequested = 1;
                $integration->isEmailSent = 1;
                $integration->config = $default_config;
                $integration->recorded_date = date('Y-m-d h:i:s');
                
                if (!$integration->save()) return $this->response(false, 'Cannot process javascript integration request', null, 400);

                // Sends request notification
                $this->sendRequestNotification($employer->id);

                return $this->response(true, 'Javascript integration request was successfully send', null, 200);
            }
            return $this->response(false, 'Theres a javascript integration already', null, 409);
        }
    }

    /**
     * Get Javascript Integration Status
     *
     * @param [object] $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJsIntegrationStatus($request)
    {
        $employer_id = $request->employer_id;
        $employer = Employer::find($employer_id);
        
        if ($employer) {
            if ($this->checkIfIntegrationExist($employer->company_id)) {
                $integration = Integration::where('company_id', $employer->company_id)->get();
                $message = 'Enabled';
                return response()->json(['success' => true, 'message' => $message, 'data' => $integration[0]], 200);
            }
        }
    }

    /**
     * Get Javascript Integration Config
     *
     * @param [object] $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getJsIntegrationConfig($request)
    {
        $integration_config = Integration::where('company_id', $request->company_id)
                                ->select('config')
                                ->get();
        return $integration_config;
    }

    /**
     * Store Javascript Integration Config
     *
     * @param [object] $request
     * @return void
     */
    public function storeJsIntegrationConfig($request)
    {
        $integration = Integration::where('company_id', $request->company_id)->first();
        $integration->config = $request->config;
        if (!$integration->save()) return $this->response(false, 'Cannot process javascript integration request', null, 400);
        return $this->response(true, 'Javascript integration config was successfully updated', null, 200);
    }

    /**
     * Send Javascript Integration Request Notification
     *
     * @param [string] $employer_id
     * @return void
     */
    private function sendRequestNotification(string $employer_id)
    {
        $employer = Employer::where('id', $employer_id)
                        ->with('company')
                        ->with('user')
                        ->get();

        if (count($employer) > 0) {
            $full_name = $employer[0]->user->first_name . ' ' . $employer[0]->user->last_name;
            $company_name = $employer[0]->company->company_name;
            $account_type = $employer[0]->account_type_id;

            $subject = 'Javascript integration requested by ' . $company_name;
            $to = ($account_type === 5) ? $this->getAdminEmails($employer[0]->company_id) : $employer[0]->user->email;
            Mail::send('email.js-integration-request', ['full_name' => $full_name, 'company_name' => $company_name], 
                function ($message) use ($subject, $to) {
                    $message->subject($subject);
                    $message->from(getenv('MANDRILL_ADDRESS', 'PreviewMe'));
                    $message->to($to);
                });
        }

    }

    /**
     * Get Admin Emails
     *
     * @param [string] $company_id
     * @return Array
     */
    private function getAdminEmails(string $company_id)
    {
        $employer_admins = Employer::where('company_id', $company_id)
                        ->where('account_type_id', 5) 
                        ->with('user')
                        ->get();

        $admin_emails = [];
        if (count($employer_admins) > 0) {
            foreach ($employer_admins as $employer)
                array_push($admin_emails, $employer->user->email);
        }

        return $admin_emails;
    }

    /**
     * Check if a request has already been set
     *
     * @param [string] $company_id
     * @return Boolean
     */
    private function checkIfIntegrationExist(string $company_id)
    {
        $integration = Integration::where('company_id', $company_id)->get();
        return (count($integration) > 0) ? true : false;
    }

    /**
     * Check if Email Exists
     *
     * @param [string] $email
     * @return Boolean
     */
    private function checkEmailIfExist(string $email)
    {
        $user = PmUser::where('email', $email)->get();
        return (count($user) > 0) ? true : false;
    }

    /**
     * Check if current password match
     * 
     * @param [string] $user_id
     * @param [string] $password
     * @return Boolean
     */
    private function checkifPasswordMatch(string $user_id, string $password)
    {   
        $user = PmUser::find($user_id);
        return Hash::check($password, $user->password);
    }

    /**
     * Get Open Roles
     */
    public function getOpenRoles($employer_id)
    {
        $open_roles = array();

        $jobs = Job::where([['created_by_id', $employer_id], ['job_status', 'active']])
                    ->with('location')
                    ->with('company')
                    ->orderBy('expiry_date', 'desc')->get();
        $jobs = json_decode($jobs);
        $date_now = strtotime(date("Y-m-d"));

        foreach ($jobs as $key => $value) {
            $open_roles[$key]['job_title'] = $value->job_title;
            $open_roles[$key]['object_id'] = $value->object_id;
            $open_roles[$key]['closing_date'] = date("D, j M Y", strtotime($value->closing_date));

            $is_job_expired = false;
            $expiry_date = strtotime($value->expiry_date);
            if ($date_now >= $expiry_date)
                $is_job_expired = true;

            $open_roles[$key]['is_job_expired'] = $is_job_expired;
            $open_roles[$key]['location']['id'] = $value->location->id;
            $open_roles[$key]['location']['display_name'] = $value->location->display_name;
            $open_roles[$key]['location']['slug_name'] = $value->location->slug_name;
            $open_roles[$key]['location']['type'] = $value->location->type;

            $country = Country::where('id', $value->location->country_id)->first();
            $country = json_decode($country);

            $open_roles[$key]['location']['country']['id'] = $country->id;
            $open_roles[$key]['location']['country']['display_name'] = $country->displayName;
            $open_roles[$key]['location']['country']['short_name'] = $country->codeDisplayName;
            $open_roles[$key]['id'] = $value->id;
            $open_roles[$key]['job_status'] = $value->job_status;
            $open_roles[$key]['expiry_date'] = date("D, j M Y", strtotime($value->expiry_date));

            $expiry_days_left = 0;
            if ($expiry_date > $date_now)
                $expiry_days_left = ($expiry_date - $date_now) / 86400;

            $open_roles[$key]['expiry_days_left'] = round($expiry_days_left);

            $closing_days_left = 0;
            $closing_date = strtotime($value->closing_date);
            if ($closing_date > $date_now)
                $closing_days_left = ($closing_date - $date_now) / 86400;

            $open_roles[$key]['closing_days_left'] = round($closing_days_left);
            $open_roles[$key]['date_created'] = date("D, j M Y", strtotime($value->recorded_date));
            $open_roles[$key]['published_date'] = date("D, j M Y", strtotime($value->published_date));

            $expiring_this_week = false;
            if ($expiry_days_left <= 7)
                $expiring_this_week = true;

            $open_roles[$key]['expiring_this_week'] = $expiring_this_week;

            $open_roles[$key]['manager'] = "";
            if (!empty($value->job_manager_id)) {
                $muser_id = $this->getUserId($value->job_manager_id);
                $manager = PMUser::where('id', $muser_id)->first();
                $manager = json_decode($manager);
                $open_roles[$key]['manager'] = $manager->first_name." ".$manager->last_name;
            }

            $open_roles[$key]['creator'] = "";
            if (!empty($value->created_by_id)) {
                $cuser_id = $this->getUserId($value->created_by_id);
                $creator = PMUser::where('id', $cuser_id)->first();
                $creator = json_decode($creator);
                $open_roles[$key]['creator'] = $creator->first_name." ".$creator->last_name;
            }

            $default_counters = array(
                                    'long_list' => 0,
                                    'short_list' => 0,
                                    'interview' => 0,
                                    'hired' => 0,
                                    'rejected' => 0
                                );
            $get_counters = JobDefaultWorkflowStep::where([['j_job_workflow_step.job_id', $value->id], ['j_default_workflow_step.forced', '1']])
                                ->join('j_job_workflow_step', 'j_default_workflow_step.id', '=', 'j_job_workflow_step.original_workflow_step_id')
                                ->select('j_job_workflow_step.id', 'j_default_workflow_step.slug_name')->get();
            $get_counters = json_decode($get_counters);
            foreach ($get_counters as $ckey => $cvalue)
                $open_roles[$key]['counters'][$cvalue->slug_name] = JobWorkflowProgress::where('move_to_id', $cvalue->id)->count();

            $open_roles[$key]['counters']['passed_applicants'] = CandidateJobApplication::where([['job_id', $value->id], ['app_status', CandidateJobApplication::APPLIED]])->count();

            $members = Employer::where('company_id', $value->company_id)->join('pm_user', 'e_employer.user_id', '=', 'pm_user.id')->get();
            $members = json_decode($members);
            foreach ($members as $mkey => $mvalue) {
                $open_roles[$key]['members'][$mkey]['first_name'] = $mvalue->first_name;
                $open_roles[$key]['members'][$mkey]['last_name'] = $mvalue->last_name;
                $open_roles[$key]['members'][$mkey]['profile_url'] = false;
                $open_roles[$key]['members'][$mkey]['profile_image'] = false;
                $open_roles[$key]['members'][$mkey]['company_name'] = $value->company->company_name;
            }
        }

        return $open_roles;
    }


    /**
     * Get Closed Jobs
     */
    public function getClosedJobs($employer_id)
    {
        $closed_jobs = array();

        $jobs = Job::where([['created_by_id', $employer_id], ['job_status', 'closed']])
                    ->with('location')
                    ->with('company')
                    ->with('industry')
                    ->orderBy('expiry_date', 'desc')->get();
        $count = $jobs->count();
        $jobs = json_decode($jobs);
        $date_now = strtotime(date("Y-m-d"));

        foreach ($jobs as $key => $value) {
            $closed_jobs[$key]['job_title'] = $value->job_title;
            $closed_jobs[$key]['object_id'] = $value->object_id;
            $closed_jobs[$key]['closing_date'] = date("D, j M Y", strtotime($value->closing_date));

            $is_job_expired = false;
            $expiry_date = strtotime($value->expiry_date);
            if($date_now >= $expiry_date)
                $is_job_expired = true;

            $closed_jobs[$key]['is_job_expired'] = $is_job_expired;
            $closed_jobs[$key]['location']['id'] = $value->location->id;
            $closed_jobs[$key]['location']['display_name'] = $value->location->display_name;
            $closed_jobs[$key]['location']['slug_name'] = $value->location->slug_name;
            $closed_jobs[$key]['location']['type'] = $value->location->type;

            $country = Country::where('id', $value->location->country_id)->first();
            $country = json_decode($country);

            $closed_jobs[$key]['location']['country']['id'] = $country->id;
            $closed_jobs[$key]['location']['country']['display_name'] = $country->displayName;
            $closed_jobs[$key]['location']['country']['short_name'] = $country->codeDisplayName;
            $closed_jobs[$key]['expiry_date'] = date("D, j M Y", strtotime($value->expiry_date));
            $closed_jobs[$key]['closed_date'] = date("D, j M Y", strtotime($value->closed_date));
            $closed_jobs[$key]['job_description'] = $value->job_description;

            $company = Company::where('id', $value->company_id)
                                ->with('industry')
                                ->with('location')->first();
            $company = json_decode($company);

            $closed_jobs[$key]['company']['id'] = $company->id;
            $closed_jobs[$key]['company']['company_name'] = $company->company_name;
            $closed_jobs[$key]['company']['status'] = $company->status;
            $closed_jobs[$key]['company']['num_of_employees'] = $company->num_of_employees;
            $closed_jobs[$key]['company']['logo_url'] = $company->logo_url;
            $closed_jobs[$key]['company']['website_url'] = $company->website_url;
            $closed_jobs[$key]['company']['company_phone'] = $company->company_phone;
            $closed_jobs[$key]['company']['company_fax'] = $company->company_fax;

            $closed_jobs[$key]['company']['industry']['data']['industry']['id'] = $company->industry->id;
            $closed_jobs[$key]['company']['industry']['data']['industry']['display_name'] = $company->industry->display_name;
            $closed_jobs[$key]['company']['industry']['data']['sub'] =array();

            $closed_jobs[$key]['company']['street_address'] = $company->street_address;
            $closed_jobs[$key]['company']['street_address_2'] = $company->street_address_2;

            $closed_jobs[$key]['company']['location']['data']['id'] = $company->location->id;
            $closed_jobs[$key]['company']['location']['data']['display_name'] = $company->location->display_name;
            $closed_jobs[$key]['company']['location']['data']['slug_name'] = $company->location->slug_name;
            $closed_jobs[$key]['company']['location']['data']['type'] = $company->location->type;

            $c_country = Country::where('id', $company->location->country_id)->first();
            $c_country = json_decode($c_country);

            $closed_jobs[$key]['company']['location']['data']['country']['id'] = $c_country->id;
            $closed_jobs[$key]['company']['location']['data']['country']['display_name'] = $c_country->displayName;
            $closed_jobs[$key]['company']['location']['data']['country']['short_name'] = $c_country->codeDisplayName;

            $closed_jobs[$key]['company']['nz_business_num'] = $company->nz_business_num;
            $closed_jobs[$key]['company']['company_url'] = $company->company_url;
            $closed_jobs[$key]['company']['company_banner_url'] = $company->company_banner_url;
            $closed_jobs[$key]['company']['company_description'] = $company->company_description;

            $closed_jobs[$key]['company']['company_video']['doc_file_type'] = '';
            $closed_jobs[$key]['company']['company_video']['doc_url'] = '';
            $closed_jobs[$key]['company']['company_video']['doc_filename'] = '';

            if (!empty($company->company_video_id)){
                $video = EmployerDoc::where('id', $company->company_video_id)->first();
                $video = json_decode($video);

                $closed_jobs[$key]['company']['company_video']['doc_file_type'] = $video->doc_file_type;
                $closed_jobs[$key]['company']['company_video']['doc_url'] = $video->doc_url;
                $closed_jobs[$key]['company']['company_video']['doc_filename'] = $video->doc_filename;
            }

            $closed_jobs[$key]['company']['company_branch_locations'] = json_decode($company->company_branch_locations);
            $closed_jobs[$key]['company']['helper_text'] = $company->helper_text;
            $closed_jobs[$key]['other_teams'] = array();

            $members = Employer::where('company_id', $value->company_id)->join('pm_user', 'e_employer.user_id', '=', 'pm_user.id')->get();
            $members = json_decode($members);
            foreach ($members as $mkey => $mvalue) {
                $closed_jobs[$key]['other_members'][$mkey]['first_name'] = $mvalue->first_name;
                $closed_jobs[$key]['other_members'][$mkey]['last_name'] = $mvalue->last_name;
                $closed_jobs[$key]['other_members'][$mkey]['profile_picture_url'] = '';
            }

            $closed_jobs[$key]['total_applicants'] = CandidateJobApplication::where('job_id', $value->id)->count();
            $closed_jobs[$key]['failed_pre-approval'] = CandidateJobApplication::where([['job_id', $value->id], ['app_status', 'rejected']])->count();

            $closed_jobs[$key]['creator'] = "";
            if (!empty($value->created_by_id)) {
                $cuser_id = $this->getUserId($value->created_by_id);
                $creator = PMUser::where('id', $cuser_id)->first();
                $creator = json_decode($creator);
                $closed_jobs[$key]['creator'] = $creator->first_name." ".$creator->last_name;
            }

            $closed_jobs[$key]['manager'] = "";
            if (!empty($value->job_manager_id)) {
                $muser_id = $this->getUserId($value->job_manager_id);
                $manager = PMUser::where('id', $muser_id)->first();
                $manager = json_decode($manager);
                $closed_jobs[$key]['manager'] = $manager->first_name." ".$manager->last_name;
            }

            $closed_jobs[$key]['date_created'] = date("D, j M Y", strtotime($value->recorded_date));
            $closed_jobs[$key]['id'] = $value->id;
            $closed_jobs[$key]['job_closing_reason'] = $value->job_closing_reason;
            $closed_jobs[$key]['auto_close'] = $value->auto_close;
            $closed_jobs[$key]['auto_expire'] = $value->auto_expire;
            
            $expiry_days_left = 0;
            if ($expiry_date > $date_now)
                $expiry_days_left = ($expiry_date - $date_now) / 86400;

            $closed_jobs[$key]['expiry_days_left'] = round($expiry_days_left);

            $closing_days_left = 0;
            $closing_date = strtotime($value->closing_date);
            if ($closing_date > $date_now)
                $closing_days_left = ($closing_date - $date_now) / 86400;

            $closed_jobs[$key]['closing_days_left'] = round($closing_days_left);
        }

        $return = array("count" => $count, "jobs" => $closed_jobs);

        return $return;
    }


    /**
     * Get Draft Jobs
     */
    public function getDraftJobs($employer_id)
    {
        $draft_jobs = array();

        $jobs = Job::where([['created_by_id', $employer_id], ['job_status', 'draft']])
                    ->with('location')
                    ->with('company')
                    ->with('industry')
                    ->orderBy('expiry_date', 'desc')->get();
        $count = $jobs->count();
        $jobs = json_decode($jobs, true);
        // dd($jobs);
        $date_now = strtotime(date("Y-m-d"));

        foreach ($jobs as $key => $value) {
            // dd($value);
            $draft_jobs[$key]['job_title'] = $value['job_title'];
            $draft_jobs[$key]['object_id'] = $value['object_id'];
            $draft_jobs[$key]['closing_date'] = date("D, j M Y", strtotime($value['closing_date']));

            $is_job_expired = false;
            $expiry_date = strtotime($value['expiry_date']);
            if ($date_now >= $expiry_date)
                $is_job_expired = true;

            $draft_jobs[$key]['is_job_expired'] = $is_job_expired;
            $draft_jobs[$key]['location']['id'] = $value['location']['id'];
            $draft_jobs[$key]['location']['display_name'] = $value['location']['display_name'];
            $draft_jobs[$key]['location']['slug_name'] = $value['location']['slug_name'];
            $draft_jobs[$key]['location']['type'] = $value['location']['type'];

            $country = Country::where('id', $value['location']['country_id'])->first();
            $country = json_decode($country, true);

            $draft_jobs[$key]['location']['country']['id'] = $country['id'];
            $draft_jobs[$key]['location']['country']['display_name'] = $country['displayName'];
            $draft_jobs[$key]['location']['country']['short_name'] = $country['codeDisplayName'];
            $draft_jobs[$key]['expiry_date'] = date("D, j M Y", strtotime($value['expiry_date']));
            $draft_jobs[$key]['closed_date'] = date("D, j M Y", strtotime($value['closed_date']));
            $draft_jobs[$key]['job_description'] = $value['job_description'];

            $company = Company::where('id', $value['company_id'])
                                ->with('industry')
                                ->with('location')->first();
            $company = json_decode($company);

            $draft_jobs[$key]['company']['id'] = $company->id;
            $draft_jobs[$key]['company']['company_name'] = $company->company_name;
            $draft_jobs[$key]['company']['status'] = $company->status;
            $draft_jobs[$key]['company']['num_of_employees'] = $company->num_of_employees;
            $draft_jobs[$key]['company']['logo_url'] = $company->logo_url;
            $draft_jobs[$key]['company']['website_url'] = $company->website_url;
            $draft_jobs[$key]['company']['company_phone'] = $company->company_phone;
            $draft_jobs[$key]['company']['company_fax'] = $company->company_fax;

            $draft_jobs[$key]['company']['industry']['data']['industry']['id'] = $company->industry->id;
            $draft_jobs[$key]['company']['industry']['data']['industry']['display_name'] = $company->industry->display_name;
            $draft_jobs[$key]['company']['industry']['data']['sub'] =array();

            $draft_jobs[$key]['company']['street_address'] = $company->street_address;
            $draft_jobs[$key]['company']['street_address_2'] = $company->street_address_2;

            $draft_jobs[$key]['company']['location']['data']['id'] = $company->location->id;
            $draft_jobs[$key]['company']['location']['data']['display_name'] = $company->location->display_name;
            $draft_jobs[$key]['company']['location']['data']['slug_name'] = $company->location->slug_name;
            $draft_jobs[$key]['company']['location']['data']['type'] = $company->location->type;

            $c_country = Country::where('id', $company->location->country_id)->first();
            $c_country = json_decode($c_country);

            $draft_jobs[$key]['company']['location']['data']['country']['id'] = $c_country->id;
            $draft_jobs[$key]['company']['location']['data']['country']['display_name'] = $c_country->displayName;
            $draft_jobs[$key]['company']['location']['data']['country']['short_name'] = $c_country->codeDisplayName;

            $draft_jobs[$key]['company']['nz_business_num'] = $company->nz_business_num;
            $draft_jobs[$key]['company']['company_url'] = $company->company_url;
            $draft_jobs[$key]['company']['company_banner_url'] = $company->company_banner_url;
            $draft_jobs[$key]['company']['company_description'] = $company->company_description;

            $draft_jobs[$key]['company']['company_video']['doc_file_type'] = '';
            $draft_jobs[$key]['company']['company_video']['doc_url'] = '';
            $draft_jobs[$key]['company']['company_video']['doc_filename'] = '';

            if (!empty($company->company_video_id)){
                $video = EmployerDoc::where('id', $company->company_video_id)->first();
                $video = json_decode($video);

                $draft_jobs[$key]['company']['company_video']['doc_file_type'] = $video->doc_file_type;
                $draft_jobs[$key]['company']['company_video']['doc_url'] = $video->doc_url;
                $draft_jobs[$key]['company']['company_video']['doc_filename'] = $video->doc_filename;
            }

            $draft_jobs[$key]['company']['company_branch_locations'] = json_decode($company->company_branch_locations);
            $draft_jobs[$key]['company']['helper_text'] = $company->helper_text;
            $draft_jobs[$key]['other_teams'] = array();

            $members = Employer::where('company_id', $value['company_id'])->join('pm_user', 'e_employer.user_id', '=', 'pm_user.id')->get();
            $members = json_decode($members);
            foreach ($members as $mkey => $mvalue) {
                $draft_jobs[$key]['other_members'][$mkey]['first_name'] = $mvalue->first_name;
                $draft_jobs[$key]['other_members'][$mkey]['last_name'] = $mvalue->last_name;
                $draft_jobs[$key]['other_members'][$mkey]['profile_picture_url'] = '';
            }

            $draft_jobs[$key]['total_applicants'] = CandidateJobApplication::where('job_id', $value['id'])->count();
            $draft_jobs[$key]['failed_pre-approval'] = CandidateJobApplication::where([['job_id', $value['id']], ['app_status', 'rejected']])->count();

            $draft_jobs[$key]['creator'] = "";
            if (!empty($value['created_by_id'])) {
                $cuser_id = $this->getUserId($value['created_by_id']);
                $creator = PMUser::where('id', $cuser_id)->first();
                $creator = json_decode($creator);
                $draft_jobs[$key]['creator'] = $creator->first_name." ".$creator->last_name;
            }

            $draft_jobs[$key]['manager'] = "";
            if (!empty($value['job_manager_id'])) {
                $muser_id = $this->getUserId($value['job_manager_id']);
                $manager = PMUser::where('id', $muser_id)->first();
                $manager = json_decode($manager);
                $draft_jobs[$key]['manager'] = $manager->first_name." ".$manager->last_name;
            }

            $draft_jobs[$key]['date_created'] = date("D, j M Y", strtotime($value['recorded_date']));
            $draft_jobs[$key]['id'] = $value['id'];
            $draft_jobs[$key]['job_closing_reason'] = $value['job_closing_reason'];
            $draft_jobs[$key]['auto_close'] = $value['auto_close'];
            $draft_jobs[$key]['auto_expire'] = $value['auto_expire'];
            
            $expiry_days_left = 0;
            if ($expiry_date > $date_now)
                $expiry_days_left = ($expiry_date - $date_now) / 86400;

            $draft_jobs[$key]['expiry_days_left'] = round($expiry_days_left);

            $closing_days_left = 0;
            $closing_date = strtotime($value['closing_date']);
            if ($closing_date > $date_now)
                $closing_days_left = ($closing_date - $date_now) / 86400;

            $draft_jobs[$key]['closing_days_left'] = round($closing_days_left);
        }

        $return = array("count" => $count, "jobs" => $draft_jobs);

        return $return;
    }


    /**
     * Get Watchlist
     */
    public function getWatchlist($employer_id)
    {
        $watchlist = array();

        $watchlist = EmployerCandidateWatchlist::where('employer_id', $employer_id)
                        ->join('candidate', 'e_candidate_watchlist.candidate_id', '=', 'candidate.id')
                        ->join('pm_user', 'candidate.user_id', '=', 'pm_user.id')
                        ->join('industry', 'candidate.industry_id', '=', 'industry.id')
                        ->join('location', 'candidate.preferred_location_id', '=', 'location.id')
                        ->select('pm_user.first_name', 'pm_user.last_name', 'candidate.profile_url', 'industry.display_name AS industry_display_name', 'location.display_name AS preferred_location')->get();
        $count = $watchlist->count();
        if (!empty($count))
            $watchlist = json_decode($watchlist);
        
        return $watchlist;

    }

    /**
     * Get Employers Permissions
     *
     * @param [type] $request
     * @return Object
     */
    public function getPermissions($request)
    {   
        $can_create_team = false;
        $can_edit_profile = false;
        $can_edit_account_type = false;
        $employer_permissions = [];
        $employer = Employer::select('id')
                            ->where('id', $request->employer_id)
                            ->with('permissions.permission')
                            ->first();

        if ($employer) {
            $permissions = json_decode($employer->permissions);

            foreach ($permissions as $perm_key => $perm_value) {
                if ($permissions[$perm_key]->permission->id === 17) {
                    $can_create_team = true;
                }
                if ($permissions[$perm_key]->permission->id === 12) {
                    $can_edit_profile = true;
                }
                if ($permissions[$perm_key]->permission->id === 64) {
                    $can_edit_account_type = true;
                }
            }
        }
        
        $employer_permissions['create_new_teams'] = $can_create_team;
        $employer_permissions['edit_company_profile'] = $can_edit_profile;
        $employer_permissions['modify_company_member_account_type'] = $can_edit_account_type;

        return $employer_permissions;
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
