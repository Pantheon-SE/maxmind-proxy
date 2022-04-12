<?php

use GeoIp2\Database\Reader;

/** 
 * @var \Laravel\Lumen\Routing\Router $router
 */

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


$router->get('/asn/{ip}', function ($ip) use ($router) {
    $reader = new Reader('../geolite/GeoLite2-ASN.mmdb');
    return $reader->asn($ip);
})->middleware('cache.headers:public,max-age=2592000');

$router->get('/city/{ip}', function ($ip) use ($router) {
    $reader = new Reader('../geolite/GeoLite2-City.mmdb');
    return $reader->city($ip);
})->middleware('cache.headers:public,max-age=2592000');

$router->get('/country/{ip}', function ($ip) use ($router) {
    $reader = new Reader('../geolite/GeoLite2-Country.mmdb');
    return $reader->country($ip);
})->middleware('cache.headers:public,max-age=2592000');
