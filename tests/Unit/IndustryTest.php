<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndustryTest extends TestCase
{
    public function test_get_industry_api()
    {
        $industryCols = ['id', 'display_name', 'slug_name', 'parent_id', 'type'];

        $this->json('GET', $this->callApi('industries'))
            ->assertStatus(200)
            ->assertJsonStructure(['*' => $industryCols]);

        array_push($industryCols, 'sub');

        $this->json('GET', $this->callApi('industries?type=all'))
            ->assertStatus(200)
            ->assertJsonStructure(['*' => $industryCols]);
    }
}
