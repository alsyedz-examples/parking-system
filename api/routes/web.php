<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'namespace' => 'API'], function () use ($router) {
    $router->group(['prefix' => 'v1', 'namespace' => 'V1'], function () use ($router) {
        $router->group(['prefix' => 'parking-spots'], function () use ($router) {
            $router->get('', 'ParkingSpotController@index');

            $router->get('{id}', 'ParkingSpotController@show');
        });

        $router->group(['prefix' => 'bookings'], function () use ($router) {
            $router->get('', 'BookingController@index');

            $router->post('', 'BookingController@store');

            $router->group(['prefix' => '{id}'], function () use ($router) {
                $router->get('', 'BookingController@show');

                $router->put('', 'BookingController@update');

                $router->delete('', 'BookingController@destroy');
            });
        });
    });
});
