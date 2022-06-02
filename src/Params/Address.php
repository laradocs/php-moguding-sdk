<?php

namespace Laradocs\Moguding\Params;

class Address
{
    public string $province;

    public ?string $city;

    public string $address;

    public float $longitude;

    public float $latitude;

    public string $country;

    public function __construct(string $province, ?string $city, string $address, float $longitude, float $latitude, string $country = '中国')
    {
        $this->province = $province;
        $this->city = $city;
        $this->address = sprintf('%s%s%s%s', $country, $province, $city, $address);
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->country = $country;
    }

    public function serialize()
    {
        return [
            'country' => $this->country,
            'province' => $this->province,
            'city' => $this->city,
            'address' => $this->address,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ];
    }
}
