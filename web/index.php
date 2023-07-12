<?php

require __DIR__ . '/../vendor/autoload.php';

use MaxmindPantheon\IPLookup;
use flight\net\Request;

// Check if IP is supplied.
Flight::before('start', function(&$params, &$output){
    $request = Flight::request();
    $ip = get_ip($request);
    $url_parts = parse_url($request->url);
    if (empty($ip) && $url_parts['path'] !== '/') {
        Flight::json(['error' => 'No IP argument provided. Please provide an IP address.'], 500);
        exit();
    }

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
        header_remove('cache-control');
        Flight::json(['error' => $e->getMessage()]);
        exit();
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
        header_remove('cache-control');
        Flight::json(['error' => $e->getMessage()]);
        exit();
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
        header_remove('cache-control');
        Flight::json(['error' => $e->getMessage()]);
        exit();
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
        header_remove('cache-control');
        Flight::json(['error' => $e->getMessage()]);
        exit();
    }
});

Flight::route('/*', function () {
    $protocol = 'http://';
    if (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
    }
    Flight::render('swagger.php', ['url' => $protocol . $_SERVER['HTTP_HOST']]);
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