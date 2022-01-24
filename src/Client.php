<?php

namespace Laradocs\Moguding;

use GuzzleHttp\Psr7\Response;
use Laradocs\Moguding\Exceptions\TokenExpiredException;
use GuzzleHttp\Client as Guzzle;

class Client
{
    /**
     * @var string 接口
     */
    protected string $baseUri = 'https://api.moguding.net:9000';

    /**
     * @var string 盐值
     */
    protected string $salt = '3478cbbc33f84bd00d75d7dfa69e0daa';

    /**
     * 基本配置
     *
     * @return Guzzle
     */
    protected function client(): Guzzle
    {
        $config = [
            'base_uri' => $this->baseUri,
            'timeout' => 1.5,
        ];
        $factory = new Guzzle ( $config );

        return $factory;
    }

    /**
     * 用户登录
     *
     * @param string $driver
     * @param string $phone
     * @param string $password
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function login ( string $device, string $phone, string $password ): array
    {
        $response = $this->client()
            ->post ( 'session/user/v1/login', [
                'json' => [
                    'loginType' => $device,
                    'phone' => $phone,
                    'password' => $password
                ],
            ] );

        return $this->body($response);
    }

    /**
     * 获取计划
     *
     * @param string $token
     * @param string $userType
     * @param int $userId
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function getPlan ( string $token, string $userType, int $userId ): array
    {
        $response = $this->client()
            ->post ( 'practice/plan/v3/getPlanByStu', [
                'headers' => [
                    'authorization' => $token,
                ],
                'json' => [
                    'roleKey' => $userType,
                    'sign'    => md5 ( sprintf ( '%d%s%s', $userId, $userType, $this->salt ) ),
                ],
            ] );

        return $this->body($response);
    }

    /**
     * 打卡保存
     *
     * @param string $token
     * @param int $userId
     * @param string $province
     * @param string $city
     * @param string $address
     * @param float $longitude
     * @param float $latitude
     * @param string $type
     * @param string $device
     * @param string $planId
     * @param string|null $description
     * @param string $country
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function save ( string $token, int $userId, string $province, ?string $city, string $address, float $longitude, float $latitude, string $type, string $device, string $planId, ?string $description, string $country = '中国' ): array
    {
        if ( empty ( $city ) ) {
            $city = $province;
        }
        $response = $this->client()
            ->post ( 'attendence/clock/v2/save', [
                'headers' => [
                    'authorization' => $token,
                    'sign'          => md5 ( sprintf ('%s%s%s%d%s%s', ucfirst ( $device ), $type, $planId, $userId, $address, $this->salt ) ),
                ],
                'json' => [
                    'country'     => $country,
                    'province'    => $province,
                    'city'        => $city,
                    'address'     => $address,
                    'longitude'   => $longitude,
                    'latitude'    => $latitude,
                    'type'        => $type,
                    'device'      => ucfirst ( $device ),
                    'planId'      => $planId,
                    'description' => $description,
                ],
            ] );

        return $this->body($response);
    }

    /**
     * 返回响应数据
     *
     * @param Response $response
     * @return array
     * @throws \JsonException
     */
    protected function body ( Response $response ): array
    {
        $body = $response->getBody();
        try {
            $data = json_decode ( $body, true, 512, JSON_THROW_ON_ERROR );
        } catch ( TokenExpiredException ) {
            throw new TokenExpiredException();
        }

        return $data [ 'data' ] ?? [];
    }
}
