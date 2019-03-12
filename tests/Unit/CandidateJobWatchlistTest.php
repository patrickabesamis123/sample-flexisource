<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateJobWatchlistTest extends TestCase
{
    public function test_fetch_candidate_job_watchlist_api()
    {
        $jsonResponse = $this->json('GET', $this->callApi('candidate/job/watchlist'))
            ->assertStatus(200);
            
        $this->assertPaginationStructure($jsonResponse)
            ->assertJsonStructure([
                'data' => ['*' => [
                    'job' => ['job_title', 'object_id', 'expiry_date'],
                    'company' => ['name', 'company_url', 'logo_url']
                ]]
            ]);
    }
}
