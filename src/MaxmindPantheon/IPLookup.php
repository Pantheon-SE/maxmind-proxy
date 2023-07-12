<?php

namespace MaxmindPantheon;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\Reader\InvalidDatabaseException;

class IPLookup
{
    private string $ip;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Return common data.
     * @return array
     * @throws AddressNotFoundException
     * @throws InvalidDatabaseException
     */
    public function getCommon(): array
    {
        $asn = $this->getASN();
        $city = $this->getCity();
        return [
            'ip_address' => $asn['ip_address'],
            'autonomous_system_number' => $asn['autonomous_system_number'],
            'autonomous_system_organization' => $asn['autonomous_system_organization'],
            'city' => $city['city']['names']['en'],
            'state' => $city['subdivisions'][0]['names']['en'],
            'country_iso' => $city['country']['iso_code'],
            'country' => $city['country']['names']['en'],
            'group' => $city['continent']['names']['en'],
            'latitude' => $city['location']['latitude'],
            'longitude' => $city['location']['longitude'],
        ];
    }

    /**
     * @return array
     * @throws AddressNotFoundException
     * @throws InvalidDatabaseException
     */
    public function getASN(): array
    {
        $asnReader = new Reader(__DIR__ . '/../Data/GeoLite2-ASN/GeoLite2-ASN.mmdb');
        $asnData = $asnReader->asn($this->ip);
        return $asnData->jsonSerialize();
    }

    /**
     * @return array
     * @throws AddressNotFoundException
     * @throws InvalidDatabaseException
     */
    public function getCity(): array
    {
        $cityReader = new Reader(__DIR__ . '/../Data/GeoLite2-City/GeoLite2-City.mmdb');
        $cityData = $cityReader->city($this->ip);
        return $cityData->jsonSerialize();
    }

    /**
     * @return array
     * @throws AddressNotFoundException
     * @throws InvalidDatabaseException
     */
    public function getCountry(): array
    {
        $countryReader = new Reader(__DIR__ . '/../Data/GeoLite2-Country/GeoLite2-Country.mmdb');
        $countryData = $countryReader->country($this->ip);
        return $countryData->jsonSerialize();
    }
}