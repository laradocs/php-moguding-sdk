<?php

namespace Laradocs\Moguding\Params;

use Laradocs\Moguding\Exceptions\InvalidArgumentException;

class Save
{
    /**
     * 用户实例
     *
     * @var User
     */
    public User $user;

    /**
     * 地址实例
     *
     * @var Address
     */
    public Address $address;

    /**
     * 计划 ID
     *
     * @var string
     */
    public string $planId;

    /**
     * 操作系统
     *
     * @var string
     */
    public string $system;

    /**
     * 打卡类型
     *
     * @var string
     */
    public string $type;

    /**
     * 备注说明
     *
     * @var string|null
     */
    public ?string $description;

    public function __construct(User $user, Address $address, string $planId, string $system, string $type, ?string $description = null)
    {
        if (! in_array(strtolower($system), ['android', 'ios'])) {
            throw new InvalidArgumentException('The system parameter invalid value(android/ios): ' . $system);
        }
        if (! in_array($type, ['START', 'END'])) {
            throw new InvalidArgumentException('The type parameter invalid value(START/END): ' . $type);
        }

        $this->user = $user;
        $this->address = $address;
        $this->planId = $planId;
        $this->system = ucfirst($system);
        $this->type = $type;
        $this->description = $description;
    }

    /**
     * 序列化
     *
     * @return array
     */
    public function serialize(): array
    {
        return array_filter([
            'country' => $this->address->country,
            'province' => $this->address->province,
            'city' => $this->address->city,
            'address' => $this->address->address,
            'longitude' => $this->address->longitude,
            'latitude' => $this->address->latitude,
            'planId' => $this->planId,
            'device' => $this->system,
            'type' => $this->type,
            'description' => $this->description,
        ]);
    }
}
