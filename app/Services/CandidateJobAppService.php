<?php

namespace App\Services;

use App\Models\CandidateJobAppQuesAnswer;
use App\Models\CandidateDocs;
use App\Models\CandidateJobPreApplyAnswer;
use App\Models\JobApplicationQuestions;
use App\Models\JobPreApplyQuestions;

class CandidateJobAppService
{
    /**
     * Format response
     *
     * @return void
     */
    public function fotmatResponse($query)
    {
        $jobApp = array();

        $ctr = 0;
        foreach ($query as $key => $value) {
            if(isset($value['job']['id']))
            {

                if(!empty($value['job']['closing_date'])) {
                    $expiryDate = date_create($value['job']['closing_date']);
                    $expiryDate = date_format($expiryDate,"D, j M Y");

                    $daysInterval = 0;
                    if ($value['job']['closing_date'] > date('Y-m-d h:i:s'))
                    {
                        $startDate = date_create($value['job']['closing_date']);
                        $endDate = date_create()->format('Y-m-d h:i:s');
                        $endDate = date_create($endDate);
                        $interval = date_diff($startDate, $endDate);
                        $daysInterval = $interval->days;
                    }

                    $expiryDate = $expiryDate." (".$daysInterval." days)";
                }

                $jobApp[$ctr]['job'] = $value;
                $jobApp[$ctr]['job']['expiry_date'] = $expiryDate;
                $jobApp[$ctr]['job']['is_job_expired'] = "";

                $jobApp[$ctr]['job']['closed_date'] = $value['job']['closed_date'];
                $jobApp[$ctr]['job']['closing_date'] = $value['job']['closing_date'];
                $jobApp[$ctr]['job']['job_closing_reason'] = $value['job']['job_closing_reason'];
                $jobApp[$ctr]['job']['job_description'] = $value['job']['job_description'];
                $jobApp[$ctr]['job']['job_title'] = $value['job']['job_title'];
                $jobApp[$ctr]['job']['object_id'] = $value['job']['object_id'];
                $jobApp[$ctr]['job']['report_generated'] = $value['job']['report_generated'];
                
                $jobApp[$ctr]['application']['application_id'] = $value['object_id'];
                $jobApp[$ctr]['application']['applied_date'] = $value['recorded_date']->format('D, j M Y'); ;
                $ctr++;
            }
        }

        $response['count'] = count($jobApp);
        $response['jobs'] = $jobApp;

        return $response;
    }

    /**
     * Get application questions and answers
     *
     * @return void
     */
    public function getApplicationQuestions($applicationId)
    {
        $result = array();

        $candidateJobAppQuesAnswer = CandidateJobAppQuesAnswer::where('application_id', $applicationId)
                                        ->with('question')
                                        ->get();

        $ctr = 0;
        foreach ($candidateJobAppQuesAnswer as $key => $value) {
            $answerType = rtrim($value['question']['answer_type'],'"]');
            $answerType = ltrim($answerType,'["');

            $result[$ctr]['question'] = $value['question']['question'];
            $result[$ctr]['type'] = $value['type'];
            $result[$ctr]['answer_type'] = $answerType;

            $result[$ctr]['answer'] = $value['answer'];
            $file = ['video', 'file_upload'];
            if(in_array($value['type'], $file)) {
                $result[$ctr]['answer'] = CandidateDocs::where('id',$value['answer'])->first();
            }
            $ctr++;
        }

        return $result;
    }

    /**
     * Get pre appy questions and answers
     *
     * @return void
     */
    public function getPreApplyQuestions($applicationId)
    {

        $cJobPreApplyAnswer = CandidateJobPreApplyAnswer::where('application_id', $applicationId)
                                        ->get();
        
        $response = array();

        $ctr = 0;
        foreach($cJobPreApplyAnswer as $key => $value){
            
            $question = JobPreApplyQuestions::where('id', $value['question_id'])->first();

            $response[$ctr]['question'] = $question['question'];
            $response[$ctr]['answer'] = $value['answer'];
            $response[$ctr]['decides_outcome'] = $value['decides_outcome']; 
            $response[$ctr]['type'] = null; 
            $ctr++;
        }

        return $response;
    }

}
