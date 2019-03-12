<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateProfileTest extends TestCase
{
    public function test_profile_api()
    {
        $this->json('GET', $this->callApi('candidate/profile'))
             ->assertStatus(200)
             ->assertJsonStructure([
                 'first_name', 'last_name', 'email', 'profile_image', 'long_description', 'privacy' => ['settings', 'type']
             ]);
    }
}
