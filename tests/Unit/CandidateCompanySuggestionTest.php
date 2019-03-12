<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateCompanySuggestionTest extends TestCase
{
    public function test_fetch_candidate_company_suggestion_api()
    {
        $jsonResponse = $this->json('GET', $this->callApi('candidate/company/suggestion'))
            ->assertStatus(200);
            
        $this->assertPaginationStructure($jsonResponse)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'company' => [
                            'id', 'ob_key', 'name', 'logo_url', 'url', 'banner_url', 'video_url'
                        ],
                        'industry', 'location'
                    ]
                ]
            ]);
    }
}
