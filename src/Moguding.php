<?php

namespace Laradocs\Moguding;

use Laradocs\Moguding\Exceptions\HttpException;
use Laradocs\Moguding\Params\LoginParam;
use Laradocs\Moguding\Params\SaveParam;
use Laradocs\Moguding\Params\UserParam;
use Laradocs\Moguding\Traits\HasSignature;
use GuzzleHttp\Client;
use Exception;
use Laradocs\Moguding\Utils\Json;

class Moguding
{
    use HasSignature;

    protected string $baseUri = 'https://api.moguding.net:9000';

    public function getHttpClient()
    {
        $config = [
            'base_uri' => $this->baseUri,
            'timeout' => 1.5,
        ];

        return new Client($config);
    }

    /**
     * 获取用户信息
     */
    public function getUserProfile(LoginParam $param): array
    {
        try {
            $response = $this->getHttpClient()
                ->post('session/user/v1/login', $param->body())
                ->getBody()
                ->getContents();
            $data = Json::decode($response);

            return $data['code'] == 200
                ? $data['data']
                : throw new Exception($data['msg'], $data['code']);
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取计划列表
     */
    public function getPlanList(UserParam $param): array
    {
        try {
            $response = $this->getHttpClient()
                ->post('practice/plan/v3/getPlanByStu', $param->body())
                ->getBody()
                ->getContents();
            $data = Json::decode($response);

            return $data['code'] == 200
                ? $data['data']
                : throw new Exception($data['msg'], $data['code']);
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取打卡信息
     */
    public function getSaveInfo(SaveParam $param): array
    {
        try {
            $response = $this->getHttpClient()
                ->post('attendence/clock/v2/save', $param->body())
                ->getBody()
                ->getContents();
            $data = Json::decode($response);

            return $data['code'] == 200
                ? $data['data']
                : throw new Exception($data['msg'], $data['code']);
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
