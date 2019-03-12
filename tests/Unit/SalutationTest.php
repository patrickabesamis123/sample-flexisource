<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalutationTest extends TestCase
{
    public function test_fetch_salutations_api()
    {
        $this->json('GET', $this->callApi('salutations'))
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'author', 'message']);
    }
}
