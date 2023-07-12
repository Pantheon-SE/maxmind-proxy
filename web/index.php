<?php

require __DIR__ . '/../vendor/autoload.php';

use MaxmindPantheon\IPLookup;
use flight\net\Request;

// Check if IP is supplied.
Flight::before('start', function(&$params, &$output){
    $ip = get_ip(Flight::request());
    if (empty($ip)) {
        Flight::json(['error' => 'No IP argument provided. Please provide an IP address.'], 500);
        exit();
    }
});

Flight::after('start', function(&$params, &$output){
    // Cache tf out of this.
    header("Cache-Control: public, max-age=2592000, s-maxage=2592000");
    header_remove('x-powered-by');
});

/**
 * Get autonomous system IP data.
 */
Flight::route('POST|GET /asn', function () {
    $ip = get_ip(Flight::request());
    $max = new IPLookup($ip);
    try {
        $asn = $max->getASN();
        $etag = base64_encode('asn' . $ip);
        Flight::etag($etag);
        Flight::json($asn);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()]);
    }
});

/**
 * Get city-level IP data.
 */
Flight::route('POST|GET /city', function () {
    $ip = get_ip(Flight::request());
    $max = new IPLookup($ip);
    try {
        $asn = $max->getCity();
        $etag = base64_encode('city' . $ip);
        Flight::etag($etag);
        Flight::json($asn);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()]);
    }
});

/**
 * Get country-level IP data.
 */
Flight::route('POST|GET /country', function () {
    $ip = get_ip(Flight::request());
    $max = new IPLookup($ip);
    try {
        $asn = $max->getCountry();
        $etag = base64_encode('country' . $ip);
        Flight::etag($etag);
        Flight::json($asn);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()]);
    }
});

/**
 * Get country-level IP data.
 */
Flight::route('POST|GET /datastudio', function () {
    $ip = get_ip(Flight::request());
    $max = new IPLookup($ip);
    try {
        $asn = $max->getCommon();
        $etag = base64_encode('datastudio' . $ip);
        Flight::etag($etag);
        Flight::json($asn);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()]);
    }
});

Flight::route('*', function ($route) {
    var_export($route);
    echo "Try an API path!";
});

/** Get IP address
 * @param Request $request
 * @return string|null
 */
function get_ip(Request $request): ?string
{
    return ($request->method == 'POST') ? $request->data['ip']: $request->query['ip'];
}

Flight::start();