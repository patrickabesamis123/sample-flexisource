<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\WhitelistedCompanyRepositoryEloquent;
use Illuminate\Container\Container as Application;

class CandidateProfileRequestTest extends TestCase
{
    public function test_fetch_candidate_profile_request_api()
    {
        $jsonResponse = $this->json('GET', $this->callApi('candidate/profile/request'))
            ->assertStatus(200);

        $this->assertPaginationStructure($jsonResponse)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'company_name', 'company_url', 'logo_url']
                ]
            ]);
    }

    public function test_approve_disapprove_candidate_profile_request()
    {
        $repo = new WhitelistedCompanyRepositoryEloquent(new Application());
        $company = $repo->first()->id;
        $this->json('PUT', $this->callApi("candidate/profile/request/$company"), ['enabled' => 1])
            ->assertStatus(204);
    }
}
