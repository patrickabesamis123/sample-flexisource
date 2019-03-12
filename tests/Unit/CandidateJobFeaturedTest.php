<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateJobFeaturedTest extends TestCase
{
    public function test_call_candidate_featured_api()
    {
        $jsonResponse = $this->json('GET', $this->callApi('candidate/job/featured'))
            ->assertStatus(200);

        $this->assertPaginationStructure($jsonResponse)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'company' => ['name', 'banner_url', 'logo_url', 'url'],
                        'job' => ['id', 'object_id', 'title', 'watchlist'],
                        'location'
                    ]
                ]
            ]);
    }
}
