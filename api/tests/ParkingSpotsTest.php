<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;

class ParkingSpotsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_index_endpoint_of_parking_spots_api_returns_a_successful_response()
    {
        $this->artisan('db:seed');

        $response = $this->get('/api/v1/parking-spots', ['Accept' => 'application/json']);

        $response->assertResponseOk();

        $response->seeJsonStructure(['data']);
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_show_endpoint_of_parking_spots_api_returns_a_successful_response()
    {
        $this->artisan('db:seed');

        $response = $this->get('/api/v1/parking-spots/1', ['Accept' => 'application/json']);

        $response->assertResponseOk();

        $response->seeJsonStructure(['id', 'label']);
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_show_endpoint_of_parking_spots_api_returns_a_unsuccessful_response()
    {
        $response = $this->get('/api/v1/parking-spots/1', ['Accept' => 'application/json']);

        $response->assertResponseStatus(404);

        $response->seeJsonStructure(['message']);
    }
}
