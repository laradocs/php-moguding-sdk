<?php

namespace Laradocs\Moguding;

interface MogudingResolverInterface
{
    /**
     * 用户登录
     *
     * @param string $device
     * @param string $phone
     * @param string $password
     * @return array
     */
    public function login(string $device, string $phone, string $password): array;

    /**
     * 获取计划
     *
     * @param string $token
     * @param string $userType
     * @param int $userId
     * @return array
     */
    public function getPlan(string $token, string $userType, int $userId): array;

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
     * @return array
     */
    public function save(string $token, int $userId, string $province, ?string $city, string $address, float $longitude, float $latitude, string $type, string $device, string $planId, ?string $description = null, string $country = '中国'): array;
}
