<?php

namespace Tests;

use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;

class SearchTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_search_endpoint_of_search_api_returns_a_successful_response()
    {
        $this->artisan('db:seed');

        $start_date = Carbon::now()->addMinutes(20);
        $end_date = Carbon::now()->addMinutes(30);
        $this->post('/api/v1/bookings', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
            "parking_spot_id" => "1"
        ], ['Accept' => 'application/json']);

        // we should be able to search with a date rage.
        $response = $this->post('/api/v1/search', [
            "start_date" => $start_date->clone()->subMinutes(10)->format($this->dateFormat),
            "end_date" => $end_date->clone()->addMinutes(10)->format($this->dateFormat)
        ], ['Accept' => 'application/json']);

        $response->assertResponseOk();

        $response->seeJsonStructure([[
            "end_date", "start_date", "parking_spot_id"
        ]]);
    }
}
