<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Location extends TestCase
{
    public function test_get_location_api()
    {
        $this->json('GET', $this->callApi('locations'))
            ->assertStatus(200)
            ->assertJsonStructure(['*' => ['id', 'country_id', 'display_name', 'slug_name', 'parent_id', 'type', 'admin_approved', 'correction']]);

        $this->json('GET', $this->callApi('locations?type=search-display'))
            ->assertStatus(200)
            ->assertJsonStructure(['*' => ['id', 'display_name', 'parent_name']]);
    }
}
