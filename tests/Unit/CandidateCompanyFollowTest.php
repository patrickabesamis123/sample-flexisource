<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateCompanyFollowTest extends TestCase
{
    public function test_fetch_candidate_company_follow_api()
    {
        $this->json('GET', $this->callApi('candidate/company/follow'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'company_name', 'status', 'num_of_employees', 'logo_url', 'website_url', 'company_phone',
                        'company_fax', 'industry', 'street_address', 'street_address_2', 'location', 'nz_business_num',
                        'company_url', 'company_banner_url', 'company_description', 'company_video', 'company_branch_locations',
                        'helper_text'
                    ]
                ]
            ]);
    }
}
