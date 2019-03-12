<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Job;
use App\Models\JobDefaultWorkflowStep;
use App\Models\CandidateJobApplication;

class AppliedJobApplication extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'job_application' => [
                'application_id' => $this->application_id,
                'app_status' => $this->applicationStatus(),
                'applied_date' => (new \DateTime($this->applied_date))->format('D, j M Y')
            ],
            'job' => [
                'object_id' => $this->object_id,
                'job_title' => $this->job_title
            ],
            'company' => [
                'name' => $this->company_name,
                'logo_url' => $this->logo_url,
                'url' => $this->company_url
            ]
        ];
    }

    /**
     * Determine the candidate job application status
     * When candidate is in Long List bucket, display: `Long List`
     * When candidate is in Short List bucket, display: `Short List`
     * When candidate is in Interview bucket, display: `Interview`
     * When candidate is moved into a custom bucket, display: `Pending`
     * When candidate is moved into Hired bucket: Show `Hired`
     * after 48 hours (same delay as email and web notifications for Hired)
     * When candidate is moved in the Not Successful bucket, display `Not Successful` after 96 hours of being in
     * the Not Successful bucket or when the role is closed by the employer and
     * the candidate is not in the Hired bucket.
     * (Same conditions for the email and web notifications for Not Successful)
     * When the candidate is moved to Hired or Not Successful bucket,
     * display `Pending` while waiting for the corresponding delay.
     * @param [JobApplication] $application
     * @return void
     */
    private function applicationStatus()
    {
        $applicationStatus = $this->dws_name;
        $applicationStatusSlug = $this->dws_slug_name;

        $now = new \DateTime();
        $workflowDateTime = new \DateTime($this->wp_recorded_date);

        $diff = $workflowDateTime->diff($now);
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);

        if ($this->job_status === Job::CLOSED) {
            return $applicationStatus;
        }

        /**
         * When candidate is moved into Hired bucket:
         * Show `Hired` after 48 hours (same delay as email and web notifications for Hired)
         * When the candidate is moved to Hired or Not Successful bucket,
         * display `Pending` while waiting for the corresponding delay.
         */
        if ($applicationStatusSlug === JobDefaultWorkflowStep::HIRED) {
            if ($hours < 48) {
                return CandidateJobApplication::PENDING;
            }
            return $applicationStatus;
        }

        /**
         * When candidate is moved in the Not Successful bucket, display `Not Successful`
         * after 96 hours of being in the Not Successful bucket
         * or when the role is closed by the employer and the candidate is not in the Hired bucket.
         * (Same conditions for the email and web notifications for Not Successful)
         */
        if ($applicationStatusSlug === JobDefaultWorkflowStep::REJECTED) {
            if ($hours < 96) {
                return CandidateJobApplication::PENDING;
            }
            return $applicationStatus;
        }

        /**
         * When candidate is moved into a custom bucket, display: `Pending`
         */
        return $this->dws_forced ? $applicationStatus : CandidateJobApplication::PENDING;
    }
}
