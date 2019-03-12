<?php

namespace App\Repositories;

use DB, JWTAuth;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\EmployerRoleCreationInterface;
use App\Models\Job;
use App\Models\Employer;
use App\Models\Industry;
use App\Models\Template;
use App\Models\Suggestion;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class EmployerRoleCreationRepository.
 *
 * @package namespace App\Repositories;
 */
class EmployerRoleCreationRepository extends BaseRepository implements EmployerRoleCreationInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Job::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get company id
     */
    public function getCompanyId($user_id)
    {
        $company_id = Employer::where('user_id', $user_id)->select('company_id')->first();
        $company_id = json_decode($company_id);
        return $company_id->company_id;
    }


    /**
     * Get draft roles
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function drafts($company_id, $request)
    {
        $draft  = [];
        $limit = 20;
        $current_page = (empty($request->page) ? 1 : $request->page);
        $offset = ($current_page - 1) * $limit;

        $records = Job::from('j_job as j')
                    ->join('industry as i', 'i.id', '=', 'j.industry_id')
                    ->where([['j.company_id', $company_id], ['j.job_status', 'draft']])
                    ->select('j.id as job_id', 'j.job_title', 'j.job_description', 'i.display_name as industry_name', DB::raw('DATE_FORMAT(j.recorded_date, "%Y-%m-%d") as created_on'))
                    ->get();

        if (count($records) === 0) {
            return $this->response(false, 'No record found', $draft, 400);
        }

        $total_records = $records->count();

        $records = Job::from('j_job as j')
                    ->join('industry as i', 'i.id', '=', 'j.industry_id')
                    ->where([['j.company_id', $company_id], ['j.job_status', 'draft']])
                    ->select('j.id as job_id', 'j.job_title', 'j.job_description', 'i.display_name as industry_name', DB::raw('DATE_FORMAT(j.recorded_date, "%Y-%m-%d") as created_on'))
                    ->skip($offset)
                    ->take($limit)
                    ->get();
        $count = $records->count();

        $draft['records'] = $records;
        $draft['current_page'] = $current_page;
        $draft['total_pages'] = ceil($count / $limit);
        $draft['total_records'] = $total_records;
        $draft['total_records_in_current_page'] = $count;

        return $this->response(true, 'Records Found', $draft, 200);
    }


    /**
     * Get classifications
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function classifications($company_id, $request)
    {
        $classifications  = [];
        $total = 0;

        $industries = Industry::where('type', Industry::INDUSTRY)
                                ->select('id as parent_industry_id', 'display_name as parent_industry_name')
                                ->get();
        $count = $industries->count();
        if ($count === 0) {
            return $this->response(false, 'No record found', $classifications, 400);
        }

        $classifications['industries'][0]['parent_industry_id'] = '';
        $classifications['industries'][0]['parent_industry_name'] = 'ALL';
        $classifications['industries'][0]['total'] = $total;
        foreach ($industries as $key => $value) {
            $per_industry = $this->getTotalParentIndustry($value->parent_industry_id, $company_id);
            $classifications['industries'][] = [
                            'parent_industry_id' => $value->parent_industry_id, 
                            'parent_industry_name' => $value->parent_industry_name, 
                            'total' => $per_industry
                            ];
            $total += $per_industry;
        }
        $classifications['industries'][0]['total'] = $total;

        return $this->response(true, 'Records Found', $classifications, 200);
    }


    /**
     * Search for roles
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($company_id, $request)
    {
        $result  = [];
        $pre_apply = 'no';
        $standard_questions = 'no';

        $type = $request->type;
        $sort = $request->sort;
        $industry = $request->industry;
        $q = $request->q;

        if($type == "public")
        {
            $records = Template::where('company_id', $company_id)
                                ->where(function($q_where) use ($q) {
                                    $q_where->where('name', 'like', '%'.$q.'%')
                                            ->orWhere('description', 'like', '%'.$q.'%')
                                            ->orWhere('parent_industry_name', 'like', '%'.$q.'%');
                                })
                                ->select('id as template_id', 'name as template_name', 'description', 'parent_industry_id', 'parent_industry_name', 'counter');

            if(!empty($industry)) {
                $records = $records->where('parent_industry_id', $industry);
            }
            
            if(!empty($sort)) {
                switch ($sort) {
                    case '':
                        $records = $records->orderBy('id', 'DESC');
                        break;

                    case 'all':
                        $records = $records->orderBy('id', 'DESC');
                        break;

                    case 'newest':
                        $records = $records->orderBy('id', 'DESC');
                        break;

                    case 'oldest':
                        $records = $records->orderBy('id', 'ASC');
                        break;

                    case 'popular':
                        $records = $records->orderBy('counter', 'DESC');
                        break;

                    case 'alphabetical':
                        $records = $records->orderBy('name', 'ASC');
                        break;

                    default:
                        break;
                }
            }
            $records = $records->get();
            $count = $records->count();
            if ($count === 0) {
                return $this->response(false, 'No record found', $result, 400);
            }

            foreach ($records as $key => $value) {
                $pre_apply_cnt = $this->checkPreApplyQuestion($value->template_name);
                if($pre_apply_cnt) {
                    $pre_apply = 'yes';
                }
                $result['records'][$key] = [
                                'template_id' => $value->template_id, 
                                'template_name' => $value->template_name, 
                                'description' => $value->description,
                                'parent_industry_id' => $value->parent_industry_id,
                                'parent_industry_name' => $value->parent_industry_name,
                                'counter' => $value->counter,
                                'pre_approval_questions' => $pre_apply,
                                'standard_questions' => $standard_questions,
                                'old_job_id' => null
                                ];
            }
        } 
        else 
        {
            $records = Template::where(function($q_where) use ($q) {
                                            $q_where->where('j_template.name', 'like', '%'.$q.'%')
                                                    ->orWhere('j_template.description', 'like', '%'.$q.'%')
                                                    ->orWhere('j_template.parent_industry_name', 'like', '%'.$q.'%');
                                                })
                                ->where('j_job.job_status', '!=', 'draft')
                                ->join('j_job', 'j_job.id', '=', 'j_template.job_id')
                                ->join('e_employer', 'e_employer.id', '=', 'j_template.created_by_id')
                                ->join('pm_user', 'pm_user.id', '=', 'e_employer.user_id')
                                ->select('j_template.id as template_id',
                                            'j_template.name as template_name',
                                            'j_template.description',
                                            'j_template.parent_industry_id',
                                            'j_template.parent_industry_name',
                                            'j_template.counter',
                                            'j_job.id as old_job_id',
                                            'j_template.recorded_date as created_on',
                                            'pm_user.first_name',
                                            'pm_user.last_name');

            if(!empty($industry)) {
                $records = $records->where('j_template.parent_industry_id', $industry);
            }
            
            if(!empty($sort)) {
                switch ($sort) {
                    case '':
                        $records = $records->orderBy('j_template.id', 'DESC');
                        break;

                    case 'all':
                        $records = $records->orderBy('j_template.id', 'DESC');
                        break;

                    case 'newest':
                        $records = $records->orderBy('j_template.id', 'DESC');
                        break;

                    case 'oldest':
                        $records = $records->orderBy('j_template.id', 'ASC');
                        break;

                    case 'popular':
                        $records = $records->orderBy('j_template.counter', 'DESC');
                        break;

                    case 'alphabetical':
                        $records = $records->orderBy('j_template.name', 'ASC');
                        break;

                    default:
                        break;
                }
            }
            $records = $records->get();
            // print_r($records);
            // exit();
            $count = $records->count();
            if ($count === 0) {
                return $this->response(false, 'No record found', $result, 400);
            }

            foreach ($records as $key => $value) {
                $pre_apply_cnt = $this->checkPreApplyQuestion($value->template_name);
                if($pre_apply_cnt) {
                    $pre_apply = 'yes';
                }
                $result['records'][$key] = [
                                'template_id' => $value->template_id, 
                                'template_name' => $value->template_name, 
                                'description' => $value->description,
                                'parent_industry_id' => $value->parent_industry_id,
                                'parent_industry_name' => $value->parent_industry_name,
                                'counter' => $value->counter,
                                'pre_approval_questions' => $pre_apply,
                                'standard_questions' => $standard_questions,
                                'old_job_id' => $value->old_job_id,
                                'created_on' => date("m/d/Y", strtotime($value->created_on)),
                                'created_by' => $value->first_name." ".$value->last_name
                                ];
            }
        }

        

        return $this->response(true, 'Records Found', $result, 200);
    }


    /**
     * Display role details
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function preview($company_id, $template_id)
    {
        $template  = [];

        $job_id = Template::where('id', $template_id)->select('job_id')->first();

        $jobdtl = Job::where('id', $job_id['job_id'])
                        ->with('location')
                        ->with('location.country')
                        ->with('role_type')
                        ->with('job_meta')
                        ->with('accountabilities')
                        ->with('search_helpers')
                        ->with('objectives')
                        ->with('requirements')
                        ->with('benefits')
                        ->with('industry')
                        ->with('pre_apply_questions')
                        ->get();

        $template['template_data']['job_title'] = $jobdtl[0]['job_title'];
        $template['template_data']['working_days'] = json_decode($jobdtl[0]['working_days']);
        $template['template_data']['min_salary'] = $jobdtl[0]['min_salary'];
        $template['template_data']['max_salary'] = $jobdtl[0]['max_salary'];
        $template['template_data']['min_experience'] = $jobdtl[0]['min_experience'];
        $template['template_data']['max_experience'] = $jobdtl[0]['max_experience'];
        $jobdtl[0]['working_days'] = json_decode($jobdtl[0]['working_days']);
        if($jobdtl[0]['is_salary_public'] == 0) {
            $template['template_data']['is_salary_public'] = false;
        } else {
           $template['template_data']['is_salary_public'] = true;
        }
        $template['template_data']['location']['data']['id'] = $jobdtl[0]['location']['id'];
        $template['template_data']['location']['data']['display_name'] = $jobdtl[0]['location']['display_name'];
        $template['template_data']['location']['data']['slug_name'] = $jobdtl[0]['location']['slug_name'];
        $template['template_data']['location']['data']['type'] = $jobdtl[0]['location']['type'];
        $template['template_data']['location']['data']['country']['id'] = $jobdtl[0]['location']['country'][0]['id'];
        $template['template_data']['location']['data']['country']['display_name'] = $jobdtl[0]['location']['country'][0]['displayName'];
        $template['template_data']['location']['data']['country']['short_name'] = $jobdtl[0]['location']['country'][0]['codeDisplayName'];
        $template['template_data']['role_duration'] = $jobdtl[0]['role_duration'];
        $template['template_data']['role_type']['id'] = $jobdtl[0]['role_type']['id'];
        $template['template_data']['role_type']['display_name'] = $jobdtl[0]['role_type']['displayName'];
        $template['template_data']['finish_time'] = $jobdtl[0]['finish_time'];
        if($jobdtl[0]['flexible_hours'] == 0) {
            $template['template_data']['flexible_hours'] = false;
        } else {
           $template['template_data']['flexible_hours'] = true;
        }
        $job_meta = [];
        foreach($jobdtl[0]['job_meta'] as $raw_meta) {
            $job_meta[$raw_meta['meta_key']] = $raw_meta['meta_value'];
        }
        $template['template_data']['job_meta'] = $job_meta;
        $accountabilities = [];
        foreach($jobdtl[0]['accountabilities'] as $key_acc => $raw_accountabilities) {
            $accountabilities[$key_acc]['name'] = $raw_accountabilities['name'];
            $accountabilities[$key_acc]['type_display_name'] = $raw_accountabilities['type_display_name'];
            $accountabilities[$key_acc]['id'] = $raw_accountabilities['id'];
        }
        $template['template_data']['accountabilities'] = $accountabilities;
        $search_helpers = [];
        foreach($jobdtl[0]['search_helpers'] as $key_helpers => $raw_search_helpers) {
            $search_helpers[$key_helpers]['name'] = $raw_search_helpers['name'];
            $search_helpers[$key_helpers]['type_display_name'] = $raw_search_helpers['type_display_name'];
            $search_helpers[$key_helpers]['id'] = $raw_search_helpers['id'];
        }
        $template['template_data']['search_helpers'] = $search_helpers;
        $objectives = [];
        foreach($jobdtl[0]['objectives'] as $key_objectives => $raw_objectives) {
            $objectives[$key_objectives]['name'] = $raw_objectives['name'];
            $objectives[$key_objectives]['type_display_name'] = $raw_objectives['type_display_name'];
            $objectives[$key_objectives]['id'] = $raw_objectives['id'];
        }
        $template['template_data']['objectives'] = $objectives;
        $requirements = [];
        foreach($jobdtl[0]['requirements'] as $key_requirements => $raw_requirements) {
            $requirements[$key_requirements]['name'] = $raw_requirements['name'];
            $requirements[$key_requirements]['type_display_name'] = $raw_requirements['type_display_name'];
            $requirements[$key_requirements]['id'] = $raw_requirements['id'];
        }
        $template['template_data']['requirements'] = $requirements;
        $template['template_data']['responsibilities'] = $accountabilities;
        $benefits = [];
        foreach($jobdtl[0]['benefits'] as $key_benefits => $raw_benefits) {
            $benefits[$key_benefits]['name'] = $raw_benefits['name'];
            $benefits[$key_benefits]['type_display_name'] = $raw_benefits['type_display_name'];
            $benefits[$key_benefits]['id'] = $raw_benefits['id'];
        }
        $template['template_data']['benefits'] = $benefits;
        $template['template_data']['job_manager'] = $jobdtl[0]['job_manager_id'];
        $template['template_data']['job_brief'] = '';
        $template['template_data']['job_description'] = $jobdtl[0]['job_description'];
        $template['template_data']['visibility'] = json_decode($jobdtl[0]['visibility']);
        if($jobdtl[0]['industry']['type'] == "sub") {
            $industry = Industry::where('id', $jobdtl[0]['industry']['parent_id'])->get();
            $template['template_data']['industry']['data']['industry']['id'] = $industry[0]['id'];
            $template['template_data']['industry']['data']['industry']['display_name'] = $industry[0]['display_name'];
            $template['template_data']['industry']['data']['sub']['id'] = $jobdtl[0]['industry']['id'];
            $template['template_data']['industry']['data']['sub']['display_name'] = $jobdtl[0]['industry']['display_name'];
        } else {
            $template['template_data']['industry']['data']['industry']['id'] = $jobdtl[0]['industry']['id'];
            $template['template_data']['industry']['data']['industry']['display_name'] = $jobdtl[0]['industry']['display_name'];
            $template['template_data']['industry']['data']['sub']['id'] = '';
            $template['template_data']['industry']['data']['sub']['display_name'] = '';
        }
        $pre_apply_questions = [];
        foreach($jobdtl[0]['pre_apply_questions'] as $key_pre => $raw_pre_apply_questions) {
            $pre_apply_questions[$key_pre]['question'] = $raw_pre_apply_questions['question'];
            $pre_apply_questions[$key_pre]['ideal_answer'] = json_decode($raw_pre_apply_questions['ideal_answer']);
            $pre_apply_questions[$key_pre]['choices'] = json_decode($raw_pre_apply_questions['choices']);
            $pre_apply_questions[$key_pre]['decides_outcome'] = $raw_pre_apply_questions['decides_outcome'];
            $pre_apply_questions[$key_pre]['type'] = $raw_pre_apply_questions['type'];
        }
        $template['template_data']['pre_apply_questions'] = $pre_apply_questions;

        /*$jobdtl = Job::where('id', $job_id['job_id'])
                        ->join('j_job', 'j_job.id', '=', 'j_template.job_id')
                        ->join('e_employer', 'e_employer.id', '=', 'j_template.created_by_id')
                        ->join('pm_user', 'pm_user.id', '=', 'e_employer.user_id')
                        ->select('j_template.id as template_id',
                                    'j_template.name as template_name',
                                    'j_template.description',
                                    'j_template.parent_industry_id',
                                    'j_template.parent_industry_name',
                                    'j_template.counter',
                                    'j_job.id as old_job_id',
                                    'j_template.recorded_date as created_on',
                                    'pm_user.first_name',
                                    'pm_user.last_name');*/
        /*$count = $industries->count();
        if ($count === 0) {
            return $this->response(false, 'No record found', $classifications, 400);
        }

        $classifications['industries'][0]['parent_industry_id'] = '';
        $classifications['industries'][0]['parent_industry_name'] = 'ALL';
        $classifications['industries'][0]['total'] = $total;
        foreach ($industries as $key => $value) {
            $per_industry = $this->getTotalParentIndustry($value->parent_industry_id, $company_id);
            $classifications['industries'][] = [
                            'parent_industry_id' => $value->parent_industry_id, 
                            'parent_industry_name' => $value->parent_industry_name, 
                            'total' => $per_industry
                            ];
            $total += $per_industry;
        }*/

        return $this->response(true, 'Records Found', $template, 200);
    }


    /**
     * Get total per parent industry
     *
     * @param [int] $parent_industry_id
     */
    private function getTotalParentIndustry($parent_industry_id, $company_id)
    {
        $count = Template::where([['company_id', $company_id], ['parent_industry_id', $parent_industry_id]])->count();

        return $count;
    }


    /**
     * Check pre application question
     *
     * @param [int] $template_name
     */
    private function checkPreApplyQuestion($template_name)
    {
        $count = Suggestion::where([['job_title', $template_name], ['data_type', 'pre_application_question']])->count();

        return $count;
    }


    /**
     * Return Formatted JSON Response
     *
     * @param [Boolean] $success
     * @param [String] $message
     * @param [Object] $data
     * @param [Integer] $status
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($success, $message, $data, $status)
    {
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data], $status);
    }
}
