<?php

require __DIR__ . '/../vendor/autoload.php';

use GeoIp2\Database\Reader;

// Cache tf out of this.
header("Cache-Control: public, max-age=2592000");

Flight::route('/', function(){
    echo "Try an API path!";
});

Flight::route('/asn', function(){
    echo 'hello world!';
  });

Flight::route('/asn/@ip', function($ip){
    $reader = new Reader('../geolite/GeoLite2-ASN.mmdb');
    Flight::json($reader->asn($ip));
});

Flight::route('/city/@ip', function($ip){
    $reader = new Reader('../geolite/GeoLite2-City.mmdb');
    Flight::json($reader->city($ip));
});

Flight::route('/country/@ip', function($ip){
    $reader = new Reader('../geolite/GeoLite2-Country.mmdb');
    Flight::json($reader->country($ip));
});

Flight::start();
