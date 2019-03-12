<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileCompletionTest extends TestCase
{
    public function test_fetch_profile_completion_api()
    {
        $this->json('GET', $this->callApi('candidate/profile/completion'))
            ->assertStatus(200)
            ->assertJsonStructure(['icebreaker_video', 'profile_image', 'experience', 'education', 'completion', 'profile_video']);
    }
}
