<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateJobApplicationInterface;
use App\Repositories\JobMetaRepository;
use App\Validators\CandidateJobApplicationValidator;
use App\Services\CandidateJobAppService;
use App\Criteria\WithJobCriteria;
use App\Criteria\WithCompanyCriteria;
use App\Criteria\Job\ActiveJobCriteria;
use App\Criteria\JobApplication\WithJobWorkflowProgressCriteria;
use App\Criteria\WithJobWorkflowStepCriteria;
use App\Criteria\JobWorkflowStep\WithJobDefaultWorkflowStepCriteria;
use App\Models\CandidateJobApplication;
use App\Models\Job;
use App\Models\Candidate;
use App\Models\CandidateWorkhistory;
use App\Models\JobWorkflowStep;
use App\Models\JobPreApplyQuestions;
use App\Models\CandidateJobPreApplyAnswer;
use App\Models\JobApplicationQuestions;
use App\Models\CandidateJobAppQuesAnswer;
use App\Models\CandidateDocs;
use JWTAuth;

class CandidateJobApplicationRepository extends BaseRepository implements CandidateJobApplicationInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CandidateJobApplication::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getClosedJobApplication() : object
    {
        $this->pushCriteria(new WithJobCriteria('c_job_application.job_id'))
            ->pushCriteria(new WithCompanyCriteria('j_job.company_id'));

        $cols = [
            'e_company.logo_url',
            'e_company.company_url',
            'e_company.company_name',
            'j_job.job_title',
            'j_job.object_id'
        ];

        $closedJobApplication = $this->scopeQuery(function ($query) {
            $candidate = Candidate::latest()->first();
            return $query->where([
                ['j_job.job_status', Job::CLOSED],
                ['candidate_id', $candidate->id],
                ['app_status', CandidateJobApplication::APPLIED]
            ]);
        })->orderBy('c_job_application.recorded_date', 'desc')->paginate(5, $cols);

        return $closedJobApplication;
    }

    public function getAppliedJobApplication() : object
    {
        $this->pushCriteria(new WithJobCriteria('c_job_application.job_id'))
            ->pushCriteria(WithJobWorkflowProgressCriteria::class)
            ->pushCriteria(new WithJobWorkflowStepCriteria('j_job_workflow_progress.move_to_id'))
            ->pushCriteria(WithJobDefaultWorkflowStepCriteria::class)
            ->pushCriteria(new WithCompanyCriteria('j_job.company_id'))
            ->pushCriteria(ActiveJobCriteria::class);

        $cols = [
            'e_company.logo_url',
            'e_company.company_url',
            'e_company.company_name',
            'j_job.job_title',
            'j_job.object_id',
            'j_job.job_status',
            'j_job_workflow_progress.recorded_date as wp_recorded_date',
            'j_default_workflow_step.name as dws_name',
            'j_default_workflow_step.slug_name as dws_slug_name',
            'j_default_workflow_step.forced as dws_forced',
            'c_job_application.object_id as application_id',
            'c_job_application.app_status',
            'c_job_application.recorded_date as applied_date'
        ];

        $jobApplication = $this->scopeQuery(function ($query) {
            $candidate = Candidate::latest()->first();
            return $query->whereIn('job_status', [Job::ACTIVE, Job::EXPIRED])
                ->where([
                    ['candidate_id', $candidate->id],
                    ['app_status', CandidateJobApplication::APPLIED]
                ]);
        })->orderBy('c_job_application.recorded_date', 'desc')->paginate(5, $cols);

        return $jobApplication;
    }

    public function getJobApplicationByStatus($candidateId, $status)
    {
        switch($status){
            case 'active':
                $query = CandidateJobApplication::where('candidate_id', $candidateId)
                            ->where('app_status', CandidateJobApplication::APPLIED)
                            ->with(['job' => function($q) {
                                   $q->whereIn('job_status', array(Job::ACTIVE, Job::EXPIRED));
                                   $q->with('company');
                                   $q->with('location');
                                   $q->with('location.country');
                               }])
                            ->orderBy('recorded_date', 'desc')
                            ->get();

                $candidateJobAppService = new CandidateJobAppService;
                $response = $candidateJobAppService->fotmatResponse($query);

                break;
            case 'draft':
                $query = CandidateJobApplication::where('candidate_id', $candidateId)
                            ->where('app_status', CandidateJobApplication::PROCESSING)
                            ->with(['job' => function($q) {
                                   $q->whereIn('job_status', array(Job::ACTIVE));
                                   $q->with('company');
                                   $q->with('location');
                                   $q->with('location.country');
                               }])
                            ->orderBy('recorded_date', 'desc')
                            ->get();

                $candidateJobAppService = new CandidateJobAppService;
                $response = $candidateJobAppService->fotmatResponse($query);

                 break;
            case 'closed':
                $query = CandidateJobApplication::where('candidate_id', $candidateId)
                            ->where('app_status', CandidateJobApplication::APPLIED)
                            ->with(['job' => function($q) {
                                   $q->whereIn('job_status', array(Job::CLOSED));
                                   $q->with('company');
                                   $q->with('location');
                                   $q->with('location.country');
                               }])
                            ->orderBy('recorded_date', 'desc')
                            ->get();

                $candidateJobAppService = new CandidateJobAppService;
                $response = $candidateJobAppService->fotmatResponse($query);

                break;
            case 'applied';
                $query = CandidateJobApplication::where('candidate_id', $candidateId)
                            ->orderBy('recorded_date', 'desc')
                            ->get();

                $response = $query;
                break;
            case 'analytics-ready':
                $query = CandidateJobApplication::where('candidate_id', $candidateId)
                            ->whereIn('app_status', array(Job::APPLIED, Job::REJECTED))
                            ->with(['job' => function($q) {
                                   $q->where('report_generated', 1);
                                   $q->with('company');
                                   $q->with('location');
                                   $q->with('location.country');
                               }])
                            ->orderBy('recorded_date', 'desc')
                            ->get();

                $response = $query;
                break;
            default:
                $response = array();
        }

        return $response;
    }

    public function getSteps($jobObjId)
    {
        $jJob = Job::where('object_id', $jobObjId)->first();
        
        //unfinished
        //$user = JWTAuth::parseToken()->authenticate();
        //$user = json_decode($user);
        //$userId = $user->id;
        $userId = 2331;

        $candidate = Candidate::where('user_id', $userId)->first();

        $application = CandidateJobApplication::where('candidate_id', $candidate['id'])
                                            ->where('job_id', $jJob['id'])
                                            ->first();

        $appSteps = json_decode($application['app_steps'], true);

        //check if pre apply if failed - return next as rejected
        if(isset($appSteps['pre_apply_questions'])) {
            if($appSteps['pre_apply_questions'] == 'failed') {
                $update = CandidateJobApplication::find($application['id']);
                $update->app_status = 'rejected';
                $update->recorded_date = date("Y-m-d h:i:s");
                $update->save();

                return array(
                    'application_id' => $application['object_id'],
                    'next_step' => 'rejected',
                    'extra_data' => array(),
                    'all_steps' => array_keys($appSteps)
                );
            }
        }

        //check for the next active step
        $nextActiveStep = array_search('active', $appSteps);
        if(!empty($nextActiveStep)) {
            return array(
                'application_id' => $application['object_id'],
                'next_step' => $nextActiveStep,
                'extra_data' => array(),
                'all_steps' => array_keys($appSteps)
            );
        }

        //if there is not next nty step which means application is completed so run the function for application completion
        $nextNtyStep = array_search('nty', $appSteps);
        if(empty($nextNtyStep)) {
            $this->completeApplication($application['object_id']);
            return array(
                'application_id' => $application['object_id'],
                'next_step' => 'applied',
                'extra_data' => array(),
                'all_steps' => array_keys($appSteps)
            );
        } else {
            return array(
                'application_id' => $application['object_id'],
                'next_step' => $nextNtyStep,
                'extra_data' => array(),
                'all_steps' => array_keys($appSteps)
            );
        }

    }

    public function completeApplication($objectId)
    {
        // function from 
        // pvm-api\src\CandidateBundle\Services\JobApplicationService.php LINE 196
        
        $application = CandidateJobApplication::where('object_id', $objectId)->first();

        $update = CandidateJobApplication::find($application['id']);
        $update->app_status = 'applied';
        $update->recorded_date =  date("Y-m-d h:i:s");
        $update->save();

        // if candidate has experience that is realted to the roles job industry, if not, use all the job experience
        
        $jJob = Job::find($application['job_id'])->first();

        $whRelatedToJobIndustry = CandidateWorkhistory::leftJoin('c_workhistory_industry', 'c_workhistory.id', '=', 'c_workhistory_industry.work_history_id')
                                                ->where('c_workhistory.candidate_id', $application['candidate_id'])
                                                ->where('c_workhistory_industry.industry_id', $jJob['industry_id'])
                                                ->get();

        $relevant_exp = 0;
        foreach($whRelatedToJobIndustry as $key => $value)
            $relevant_exp += $value['experience_in_days'];

        $experienceInYears = intval($relevant_exp / 365);

        $related = 0;
        if($experienceInYears) {
            $experienceInDays = $relevant_exp;
            $related = 1;
        } else {
            $whNotRelatedToJobIndustry = CandidateWorkhistory::leftJoin('c_workhistory_industry', 'c_workhistory.id', '=', 'c_workhistory_industry.work_history_id')
                                                    ->leftJoin('industry', 'c_workhistory_industry.industry_id', '=', 'industry.id')
                                                    ->where('c_workhistory.candidate_id', $application['candidate_id'])
                                                    ->where('c_workhistory_industry.industry_id', '!=', $jJob['industry_id'])
                                                    ->where('industry.type', 'industry')
                                                    ->get();

            foreach($whNotRelatedToJobIndustry as $key => $value)
                $relevant_exp += $value['experience_in_days'];

            $experienceInYears = intval($relevant_exp / 365);
            $experienceInDays = $relevant_exp;
        }

        $update = CandidateJobApplication::find($application['id']);
        $update->experience_in_days = $experienceInDays;
        $update->experience_in_years = $experienceInYears;
        $update->related = $related;
        $update->save();

        // pvm-api\src\CandidateBundle\Services\JobApplicationService.php LINE 336
        // $this->calculateExtraAppData($application);

        $firstStep = JobWorkflowStep::where('job_id',$application['job_id'])
                                    ->where('priority',1)
                                    ->first();

        // UNFINISHED
        // pvm-api\src\EmployerBundle\Services\TmsService.php LINE 849
        // move the applicant to first step of workflow
        // $this->tms_service->moveApplicationToFirstWorkflowStep($application);

        //Email and notification

        /*
        $candidate = $application->getCandidate();
        $job = $application->getJob();

        $application->setAppStatus('applied');
        $application->setUpdatedDate(new \DateTime());
        // if candidate has experience that is realted to the roles job industry, if not, use all the job experience
        $experienceInYears = $this->getWorkHistoryRelatedToJobIndustry($candidate, $job, false);
        $related = 0;
        if($experienceInYears) {
            $experienceInDays = $this->getWorkHistoryRelatedToJobIndustry($candidate, $job);
            $related = 1;
        } else {
            $experienceInYears = $this->getWorkHistoryNotRelatedToJobIndustry($candidate, $job, false);
            $experienceInDays = $this->getWorkHistoryNotRelatedToJobIndustry($candidate, $job);
        }

        $application->setExperienceInDays($experienceInDays);
        $application->setExperienceInYears($experienceInYears);
        $application->setRelated($related);

        $this->calculateExtraAppData($application);

        //move the applicant to first step of workflow
        $this->tms_service->moveApplicationToFirstWorkflowStep($application);
        $templateRepo = $this->em->getRepository('CandidateBundle:EmailTemplates');
        $companyLogoUrl = $job->getCompany()->getLogoUrl();

        // Fixed RCA-39 Test real-time notifications (Candidate Email Notifications)
        //send applied notification to candidate
        $notiGroup = new NotificationGroup($candidate->getPmUser(), false);
        $emailData = $templateRepo->getEmailTemplateByType($job->getCompany(), NotiName::C_APPLICATION_RECEIVED, $job);
        $notiGroup->getNewEmailNoti('', 'email', true)
            ->setLogoUrl($companyLogoUrl)
            ->setSubjectCompanyName($job->getCompany()->getCompanyName())
            ->setMessageExplicitly($this->tms_service->coms_service->passContentThroughMergeTagsCandidate(nl2br($emailData['body']), $candidate, $job))
            ->setSubjectExplicitly($this->tms_service->coms_service->passContentThroughMergeTagsCandidate(strip_tags($emailData['subject']), $candidate, $job))
            ;
        $this->tms_service->coms_service->sendNotification($notiGroup);

        $this->em->flush();

        // [RCA-103] Send Employer Email Trigger for "Every New Candidate" who applies for a role
        $this->checkEmployerEmailSettings($job);
        */
    }

    public function calculateCompletionReturnResponse($applicationObjId, $explicit_next_step = false, $extra_data = [])
    {
        $application = CandidateJobApplication::where('object_id', $applicationObjId)->first();
        $applicationSteps = json_decode($application['app_steps'], true);

        //give internal functions capability to override this process
        if( false !== $explicit_next_step ){
            return array(
                'application_id' => $applicationObjId,
                'next_step' => $explicit_next_step,
                'extra_data' => $extra_data
            );
        }

        //check if pre apply if failed - return next as rejected
        if( isset($applicationSteps['pre_apply_questions']) ) {
            if($applicationSteps['pre_apply_questions'] == "failed") {

                $updateStatus = CandidateJobApplication::find($application['id']);
                $updateStatus->app_status = 'rejected';
                $updateStatus->updated_date = date('Y-m-d h:i:s');
                $updateStatus->save();

                return array(
                    'application_id' => $applicationObjId,
                    'next_step' => 'rejected',
                    'extra_data' => $extra_data
                );
            }
        }

        //check for the next active step
        $next_active_step = array_search('active', $applicationSteps);
        if(!empty($next_active_step)) {
            return array(
                'application_id' => $applicationObjId,
                'next_step' => $next_active_step,
                'extra_data' => $extra_data
            ); 
        }

        //if there is no next nty step which means application is completed so run the function for application completion
        $next_nty_step = array_search('nty', $applicationSteps);
        if(empty($next_nty_step)) {
            $this->completeApplication($applicationObjId);
            return array(
                'application_id' => $applicationObjId,
                'next_step' => 'applied',
                'extra_data' => $extra_data
            ); 
        } else {
            return array(
                'application_id' => $applicationObjId,
                'next_step' => $next_nty_step,
                'extra_data' => $extra_data
            );             
        }
    }


    public function postPreApplyQuestions($candidateAnswer, $jobObjId)
    {
        // Codes from pvm-api\src\CandidateBundle\Services\JobApplicationService.php LINE 497

        /** checkCandidatesPreApplyAnswers **/

        $job = Job::where('object_id', $jobObjId)->first();
        
        //unfinished
        //$user = JWTAuth::parseToken()->authenticate();
        //$user = json_decode($user);
        //$userId = $user->id;
        $userId = 2331;

        $candidate = Candidate::where('user_id', $userId)->first();

        $application = CandidateJobApplication::where('candidate_id', $candidate['id'])
                                            ->where('job_id', $job['id'])
                                            ->first();

        foreach ($candidateAnswer as $key => $val) {
            $passed = true;

            $preApplyQuestion = JobPreApplyQuestions::find($val['question_id']);
            $candidateAnswersInArray = !is_array($val['answer']) ? [$val['answer']] : $val['answer'];

            $idealAnswer = $preApplyQuestion['ideal_answer'];

            if($idealAnswer) {

                $idealAnswersInArray = $idealAnswer;     
                if(!is_array($idealAnswer)) {
                    $idealAnswer = ltrim($idealAnswer, '[');
                    $idealAnswer = rtrim($idealAnswer, ']');
                    $idealAnswersInArray = explode(',', $idealAnswer);
                }    

                /**
                * identify the format for ideal answers
                * determine if the ideal answer requires a single or multiple answer
                * empty means both arrays have no difference
                * For single array
                * case:
                *
                * [5] == [1-5] range with single set
                * [5] == [ [1-2], [4-5] ] range with multiple set
                *
                *   GPA:
                *       This is Minimum. Eg: the ideal answer is C+, so the candidate is not accepted if their GPA is less then C+
                *
                */
                $passed = 1;
                switch ($preApplyQuestion['type']) {
                    case 'gpa':
                        if($candidateAnswersInArray <= $idealAnswersInArray)
                            $passed = 0;
                        break;
                    case 'basic':
                    case 'yes-no-dev':
                        // ['a'] == ['a','b','d'] at least one is met
                        $passed = 0;
                        foreach($idealAnswersInArray as $idealAnswer) {
                            // if(in_array($idealAnswer, $candidateAnswersInArray)) {
                            //     $passed = 1;
                            //     break;
                            // }
                            if($idealAnswer == '"'.implode($candidateAnswersInArray).'"'){
                                $passed = 1;
                                break;
                            }
                        }
                    break;
                    case 'slider':
                    case 'yes-no':
                    case 'free_text':
                    break;
                    default:
                        $passed = 0;
                    break;
                }

                $answer = new CandidateJobPreApplyAnswer;
                $answer->question_id = $val['question_id'];
                $answer->answer = implode( $val['answer'] );
                $answer->result = $passed;
                $answer->recorded_date = date('Y-m-d h:i:s');
                $answer->application_id = $application['id'];
                $answer->save();
            }

        }

        $candidatesAnswers = CandidateJobPreApplyAnswer::leftJoin('j_pre_apply_questions', 'c_job_pre_apply_answer.question_id', '=', 'j_pre_apply_questions.id')
                                                        ->where('c_job_pre_apply_answer.application_id', $application['id'])
                                                        ->where('j_pre_apply_questions.type', '!=', 'free_text')
                                                        ->get();

        $preApplyQuestions = JobPreApplyQuestions::where('job_id', $job['id'])
                                                    ->where('type', '!=', 'free_text')
                                                    ->get();
        $statusCheck = 'passed';

        if(count($candidatesAnswers) != count($preApplyQuestions))
            $statusCheck = 'failed';

        foreach( $candidatesAnswers as $key => $val ) {
            $decidesOutcome = $val['decides_outcome'];
            $answerResult = $val['result'];
            if( $decidesOutcome && !$answerResult) {
                $statusCheck = 'failed';
                break;
            }
        }


        /** updateStepStatusAfterStepCheck **/

        //setStepStatus
        $applicationSteps = json_decode($application['app_steps'], true);
        if( isset($applicationSteps['pre_apply_questions']) ) {

            $applicationSteps['pre_apply_questions'] = $statusCheck;

            //setNextNtyStepActive
            if($statusCheck == 'passed') {
                foreach($applicationSteps as $key => $val) {
                    if($val == 'nty') {
                        $applicationSteps[$key] = 'active';
                        break;
                    }
                }
            }

            $newStatus = json_encode($applicationSteps);

            $updateAppSteps = CandidateJobApplication::find($application['id']);
            $updateAppSteps->app_steps = $newStatus;
            $updateAppSteps->save();

        }

        /** sendPreApplyFailedNotiToCandidate **/
        if($statusCheck == 'failed') {

            // UNFINISHED
            // pvm-api\src\CandidateBundle\Services\JobApplicationService.php LINE 551
            // $this->sendPreApplyFailedNotiToCandidate($candidate, $application->getJob());

        }

        return $this->calculateCompletionReturnResponse($applicationObjId);



        // ------

        //         foreach($candidateAnswers as $candidateAnswer) {
        //             $passed = true;
        //             $preApplyQuestion = $this->preApplyRepo->findOneBy(['id'  => $candidateAnswer['question_id'], 'job' => $job]);
        //             $candidateAnswersInArray = !is_array($candidateAnswer['answer']) ? [$candidateAnswer['answer']] : $candidateAnswer['answer'];

        //             $idealAnswer = $preApplyQuestion->getIdealAnswer();
        //             if($idealAnswer) {
        //                 $idealAnswersInArray = !is_array($idealAnswer) ? [$idealAnswer] : $idealAnswer;
        //                 $passed = $this->preApplyAnswerCheckingProcess($preApplyQuestion, $idealAnswersInArray, $candidateAnswersInArray);
        //             }

        //             $answer = new JobPreApplyAnswer();
        //             $answer->setApplication($jobApplication)
        //                 ->setAnswer($candidateAnswersInArray[0])
        //                 ->setQuestion($preApplyQuestion)
        //                 ->setResult($passed)
        //                 ;
        //             $this->em->persist($answer);
        //             $this->em->flush();
        //         }

        //         $result = true;
        //         $candidatesAnswers = $this->getCandidatesAnswers($jobApplication, true);
        //         $preApplyQuestionsCount = $this->getPreApplyQuestionsCount($job);
        //         if(count($candidatesAnswers) != $preApplyQuestionsCount)
        //             $result = false;

        //         foreach( $candidatesAnswers as $candidatesAnswer ){
        //             $decidesOutcome = $candidatesAnswer->getQuestion()->getDecidesOutcome();
        //             $answerResult = $candidatesAnswer->getResult();
        //             if( $decidesOutcome && !$answerResult){
        //                 $result = false;
        //                 break;
        //             }
        //         }

        // ---------------

    }



    public function postRequirementsCheck($data, $jobObjId , $applicationObjId)
    {
        // Codes from pvm-api\src\CandidateBundle\Services\JobApplicationService.php LINE 510

// public function checkAnswers($application, $stepType, $candidate, $data)
// {
//     if( $stepType == 'requirements_check' ){
//         $requirement_check = $this->getRequirementsCheck($application, $candidate);
//         if( empty($requirement_check) ){
//             //all good send the next step
//             $this->updateStepStatusAfterStepCheck($application, $stepType, true);
//             return $this->calculateCompletionReturnResponse($application);
//         } else{
//             //something wrong all requirements were not met
//             //send the next step back to requirements_check
//             return $this->calculateCompletionReturnResponse($application, 'requirements_check', ['missing_requirements' => $requirement_check]);
//         }
//     }
// }

        $job = Job::where('object_id', $jobObjId)->first();
        $candidate = CandidateJobApplication::where('object_id', $applicationObjId)->first();

        $jobMetaRepository = new JobMetaRepository();
        $requirement_check = $jobMetaRepository->getRequirementsCheck($job['id'], $candidate['candidate_id']);

        //unfinished
        //if( empty($requirement_check) ){
            //all good send the next step

            /** updateStepStatusAfterStepCheck **/

            // $this->updateStepStatusAfterStepCheck($application, $stepType, true);
            // private function updateStepStatusAfterStepCheck($application, $step, $newStatus = 'failed')
            // {
            //     $this->setStepStatus($application, $step, 'failed');
            //      if($newStatus){
            //          $this->setStepStatus($application, $step, 'passed');
            //          $this->setNextNtyStepActive($application);
            //      }
            // }

            $applicationSteps = json_decode($candidate['app_steps'], true);
            if( isset($applicationSteps['requirements_check']) ) {

                $applicationSteps['requirements_check'] = "passed";

                //setNextNtyStepActive
                foreach($applicationSteps as $key => $val) {
                    if($val == 'nty') {
                        $applicationSteps[$key] = 'active';
                        break;
                    }
                }
                
                $newStatus = json_encode($applicationSteps);

                $updateAppSteps = CandidateJobApplication::find($candidate['id']);
                $updateAppSteps->app_steps = $newStatus;
                $updateAppSteps->save();
            }

            return $this->calculateCompletionReturnResponse($applicationObjId);

        // } else {
        //     //something wrong all requirements were not met
        //     //send the next step back to requirements_check
        //     return $this->calculateCompletionReturnResponse($applicationObjId, 'requirements_check', ['missing_requirements' => $requirement_check]);
        // }


    }

    public function postQuestions($data, $jobObjId , $applicationObjId)
    {
        //Codes from pvm-api\src\CandidateBundle\Services\JobApplicationService.php LINE 523

        /** doAppAnswerCheckProcess **/

        $job = Job::where('object_id', $jobObjId)->first();
        $candidate = CandidateJobApplication::where('object_id', $applicationObjId)->first();
        
        $appQuestions = JobApplicationQuestions::where('job_id', $job['id'])->get();
        if(count($data) != count($appQuestions)) {
            //something wrong
            //send the next step back to application_question
            return $this->calculateCompletionReturnResponse($applicationObjId, 'application_questions');
        }

        $passed = true;
        // insert the answers first
        // candidate_answers is an array of { "question_id":23, "answer":"yes"}

        foreach( $data as $candidateAnswer ) {

            $question = JobApplicationQuestions::find($candidateAnswer['question_id'])->first();

            // ask what's the goal of this if condition? Commented for the meantime to save RA SQ answers
            // [RCA-236]
            /*
            if($question){
                $passed = false;
                continue;
            }
            */

            $ansType = str_replace(array('[', '"', ']'), '', $question['answer_type']);
            $explodeAnsType = explode(",", $ansType);

            $answer = $candidateAnswer['answer'];

            // calculate answer
            if ($explodeAnsType == 'multiple_choice' || in_array('multiple_choice', $explodeAnsType))
                $answer = json_encode((array)$candidateAnswer['answer']);

            if ($explodeAnsType == 'file_upload' || in_array('file_upload', $explodeAnsType)) {
                $cDocs = CandidateDocs::find($candidateAnswer['answer'])->first();
                if($cDocs) {
                    CandidateDocs::where('id', $cDocs['id'])
                    ->update(['doc_type' => 'application_question_answer']);

                    $answer = $cDocs['id'];
                }
            }

            //save on 'c_job_app_ques_answer' table
            $cJobAppQuesAns = new CandidateJobAppQuesAnswer;
            $cJobAppQuesAns->application_id = $candidate['id'];
            $cJobAppQuesAns->question_id = $question['id'];
            $cJobAppQuesAns->answer = $answer;
            $cJobAppQuesAns->type = $candidateAnswer['type'];
            $cJobAppQuesAns->recorded_date = date("Y-m-d h:i:s");
            $cJobAppQuesAns->save();

        }


        /** updateStepStatusAfterStepCheck **/

        $applicationSteps = json_decode($candidate['app_steps'], true);
        if( isset($applicationSteps['application_questions']) ) {

            $applicationSteps['application_questions'] = "passed";

            //setNextNtyStepActive
            foreach($applicationSteps as $key => $val) {
                if($val == 'nty') {
                    $applicationSteps[$key] = 'active';
                    break;
                }
            }

            $newStatus = json_encode($applicationSteps);

            $updateAppSteps = CandidateJobApplication::find($candidate['id']);
            $updateAppSteps->app_steps = $newStatus;
            $updateAppSteps->save();
        }

        return $this->calculateCompletionReturnResponse($applicationObjId, false);

    }

}
