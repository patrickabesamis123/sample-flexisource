<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Log;

class CandidateJobLogTest extends TestCase
{
    public function test_fetch_candidate_job_log_api()
    {
        $this->json('GET', $this->callApi('candidate/company/log'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'company', 'job' => [
                            'object_id', 'job_title'
                        ],
                        'created_at'
                    ]
                ]
            ]);
    }
}
