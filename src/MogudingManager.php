<?php

namespace Laradocs\Moguding;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Laradocs\Moguding\Exceptions\RequestTimeoutException;
use Laradocs\Moguding\Exceptions\TokenInvalidException;

class MogudingManager
{
    protected string $baseUri = 'https://api.moguding.net:9000';

    protected string $salt = '3478cbbc33f84bd00d75d7dfa69e0daa';

    public function client(): Client
    {
        $config = [
            'base_uri' => $this->baseUri,
            'timeout' => 1.5,
        ];
        $factory = new Client($config);

        return $factory;
    }

    /**
     * 用户登录
     *
     * @param string $device
     * @param string $phone
     * @param string $password
     *
     * @return array
     */
    public function login(string $device, string $phone, string $password): array
    {
        try {
            $response = $this->client()
                ->post('session/user/v1/login', [
                    'json' => [
                        'loginType' => $device,
                        'phone' => $phone,
                        'password' => $password,
                    ],
                ]);
        } catch (GuzzleException) {
            throw new RequestTimeoutException();
        }

        return $this->body($response);
    }

    /**
     * 获取计划
     *
     * @param string $token
     * @param string $userType
     * @param int $userId
     *
     * @return array
     */
    public function getPlan(string $token, string $userType, int $userId): array
    {
        try {
            $response = $this->client()
                ->post('practice/plan/v3/getPlanByStu', [
                    'headers' => [
                        'authorization' => $token,
                    ],
                    'json' => [
                        'roleKey' => $userType,
                        'sign' => md5("{$userId}{$userType}{$this->salt}"),
                    ],
                ]);
        } catch (GuzzleException) {
            throw new RequestTimeoutException();
        }


        return $this->body($response);
    }

    /**
     * 打卡保存
     *
     * @param string $token
     * @param int $userId
     * @param string $province
     * @param string|null $city
     * @param string $address
     * @param float $longitude
     * @param float $latitude
     * @param string $type
     * @param string $device
     * @param string $planId
     * @param string|null $description
     * @param string $country
     *
     * @return array
     */
    public function save(string $token, int $userId, string $province, ?string $city, string $address, float $longitude, float $latitude, string $type, string $device, string $planId, ?string $description = null, string $country = '中国'): array
    {
        $address = "{$country}{$province}{$city}{$address}";
        try {
            $response = $this->client()
                ->post('attendence/clock/v2/save', [
                    'headers' => [
                        'authorization' => $token,
                        'sign' => md5(ucfirst($device) . "{$type}{$planId}{$userId}{$address}{$this->salt}"),
                    ],
                    'json' => [
                        'country' => $country,
                        'province' => $province,
                        'city' => $city,
                        'address' => $address,
                        'longitude' => $longitude,
                        'latitude' => $latitude,
                        'type' => $type,
                        'device' => ucfirst($device),
                        'planId' => $planId,
                        'description' => $description,
                    ],
                ]);
        } catch (GuzzleException) {
            throw new RequestTimeoutException();
        }

        return $this->body($response);
    }

    protected function body(Response $response): array
    {
        $body = $response->getBody();
        $data = json_decode($body, true);
        if (isset($data['data'])) {
            return $data['data'];
        }

        throw new TokenInvalidException($data['msg']);
    }
}
