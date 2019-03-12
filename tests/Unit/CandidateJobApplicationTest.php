<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateJobApplicationTest extends TestCase
{
    public function test_candidate_job_application_applied_api()
    {
        $jsonResponse = $this->json('GET', $this->callApi('candidate/job/application/applied'))
            ->assertStatus(200);

        $this->assertPaginationStructure($jsonResponse)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'job_application' => ['application_id', 'app_status', 'applied_date'],
                        'job' => ['object_id', 'job_title'],
                        'company' => ['name', 'logo_url', 'url']
                    ]
                ]
            ]);
    }

    public function test_candidate_closed_job_application_api()
    {
        $jsonResponse = $this->json('GET', $this->callApi('candidate/job/application/closed'))
            ->assertStatus(200);

        $this->assertPaginationStructure($jsonResponse)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'job' => ['object_id', 'job_title'],
                        'company' => ['name', 'logo_url', 'url']
                    ]
                ]
            ]);
    }
}
