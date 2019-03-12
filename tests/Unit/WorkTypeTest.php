<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkTypeTest extends TestCase
{
    public function test_get_work_type_api()
    {
        $this->json('GET', $this->callApi('work-types'))
            ->assertStatus(200)
            ->assertJsonStructure(['*' => ['id', 'displayName', 'slugName']]);
    }
}
