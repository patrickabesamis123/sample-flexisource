<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Call the api route
     *
     * @param String $route - the route url
     * @return String
     */
    protected function callApi(String $route) : String
    {
        return '/api/' . $route;
    }

    /**
     * Assert if the json is paginated structure
     *
     * @param $jsonResponse
     * @return void
     */
    protected function assertPaginationStructure($jsonResponse)
    {
        return $jsonResponse->assertJsonStructure([
            'data',
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    }
}
