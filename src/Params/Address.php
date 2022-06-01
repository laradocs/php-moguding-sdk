<?php

namespace Laradocs\Moguding\Params;

class Address
{
    /**
     * 所在省份
     *
     * @var string
     */
    public string $province;

    /**
     * 所在城市
     *
     * @var string|null
     */
    public ?string $city;

    /**
     * 详细地址
     *
     * @var string
     */
    public string $address;

    /**
     * 经度
     *
     * @var float
     */
    public float $longitude;

    /**
     * 纬度
     *
     * @var float
     */
    public float $latitude;

    /**
     * 所在国家
     *
     * @var string
     */
    public string $country;

    public function __construct(string $province, ?string $city = null, string $address, float $longitude, float $latitude, string $country = '中国')
    {
        $this->province = $province;
        $this->city = $city;
        $this->address = $address;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->country = $country;
    }

    /**
     * 序列化
     *
     * @return array
     */
    public function serialize(): array
    {
        return array_filter([
            'province' => $this->province,
            'city' => $this->city,
            'address' => $this->address,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'country' => $this->country,
        ]);
    }
}
