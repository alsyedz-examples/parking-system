<?php

namespace Tests;

use Carbon\Carbon;
use DateTime;
use Laravel\Lumen\Testing\DatabaseMigrations;

class BookingsTest extends TestCase
{
    use DatabaseMigrations;

    protected $dateFormat = DateTime::ISO8601;

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_index_endpoint_of_bookings_api_returns_a_successful_response()
    {
        $this->artisan('db:seed');


        // we should see a paginated response
        $response = $this->get('/api/v1/bookings', ['Accept' => 'application/json']);
        $response->assertResponseOk();
        $response->seeJsonStructure(['data']);
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_store_endpoint_of_bookings_api_returns_a_good_response()
    {
        $this->artisan('db:seed');


        // we should be able to add a fresh record.
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addMinutes(20);
        $response = $this->post('/api/v1/bookings', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
            "parking_spot_id" => "1"
        ], ['Accept' => 'application/json']);
        $response->assertResponseOk();
        $response->seeJsonStructure(['id', 'start_date', 'end_date']);


        // we should not be able to add a our booking. Reason: Slot already booked.
        $start_date->addMinutes(10);
        $end_date->addMinutes(10);
        $response = $this->post('/api/v1/bookings', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
            "parking_spot_id" => "1"
        ], ['Accept' => 'application/json']);
        $response->assertResponseStatus(400);
        $response->seeJsonStructure(['message']);


        // we should be able to add a our booking (using same date & time). Reason: Different spot.
        $response = $this->post('/api/v1/bookings', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
            "parking_spot_id" => "2"
        ], ['Accept' => 'application/json']);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure(['id', 'start_date', 'end_date']);


        // we should be able to add a our booking (using same date & time).
        $start_date->addHours(1);
        $end_date->addHours(1);
        $response = $this->post('/api/v1/bookings', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
            "parking_spot_id" => "1"
        ], ['Accept' => 'application/json']);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure(['id', 'start_date', 'end_date']);
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_show_endpoint_of_bookings_api_returns_a_successful_response()
    {
        $this->artisan('db:seed');


        $start_date = Carbon::now();
        $end_date = Carbon::now()->addMinutes(20);
        $this->post('/api/v1/bookings', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
            "parking_spot_id" => "1"
        ], ['Accept' => 'application/json']);


        // we should be able to add a get our booking.
        $response = $this->get('/api/v1/bookings/1', ['Accept' => 'application/json']);
        $response->assertResponseOk();
        $response->seeJsonStructure(['id', 'start_date', 'end_date']);
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_show_endpoint_of_bookings_api_returns_a_unsuccessful_response()
    {
        $this->artisan('db:seed');


        // we should not be able to get out booking. Reason: Booking doesn't exist.
        $response = $this->get('/api/v1/bookings/1', ['Accept' => 'application/json']);
        $response->assertResponseStatus(404);
        $response->seeJsonStructure(['message']);
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function test_that_update_endpoint_of_bookings_api_returns_a_good_response()
    {
        $this->artisan('db:seed');


        $start_date = Carbon::now();
        $end_date = Carbon::now()->addMinutes(10);
        $this->post('/api/v1/bookings', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
            "parking_spot_id" => "1"
        ], ['Accept' => 'application/json']);
        $start_date->addMinutes(10);
        $end_date->addMinutes(10);
        $this->post('/api/v1/bookings', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
            "parking_spot_id" => "1"
        ], ['Accept' => 'application/json']);


        // we should not be able to add a our booking. Reason: Slot already booked.
        $response = $this->put('/api/v1/bookings/1', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
        ], ['Accept' => 'application/json']);
        $response->assertResponseStatus(400);
        $response->seeJsonStructure(['message']);


        // we should be able to add a our booking.
        $start_date->addMinutes(10);
        $end_date->addMinutes(10);
        $response = $this->put('/api/v1/bookings/1', [
            "start_date" => $start_date->format($this->dateFormat),
            "end_date" => $end_date->format($this->dateFormat),
        ], ['Accept' => 'application/json']);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure(['id', 'start_date', 'end_date']);
    }
}
