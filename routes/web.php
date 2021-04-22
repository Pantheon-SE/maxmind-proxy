<?php

use GeoIp2\Database\Reader;

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

function cacheResponse($content)
{
    return response($content)->header('Cache-Control', 'max-age=3600');
}

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/asn/{ip}', function ($ip) use ($router) {
    $reader = new Reader('../geolite/GeoLite2-ASN.mmdb');
    $record = $reader->asn($ip);
    return cacheResponse($record);
});

$router->get('/city/{ip}', function ($ip) use ($router) {
    $reader = new Reader('../geolite/GeoLite2-City.mmdb');
    $record = $reader->city($ip);
    return cacheResponse($record);
});

$router->get('/country/{ip}', function ($ip) use ($router) {
    $reader = new Reader('../geolite/GeoLite2-Country.mmdb');
    $record = $reader->country($ip);
    return cacheResponse($record);
});
