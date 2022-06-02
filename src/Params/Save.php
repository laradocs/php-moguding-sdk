<?php

namespace Laradocs\Moguding\Params;

use Laradocs\Moguding\Exceptions\InvalidArgumentException;

class Save
{
    /**
     * 用户实例.
     */
    public User $user;

    /**
     * 地址实例.
     */
    public Address $address;

    /**
     * 计划 ID.
     */
    public string $planId;

    /**
     * 使用设备.
     */
    public string $device;

    /**
     * 打卡类型.
     */
    public string $type;

    /**
     * 备注说明.
     */
    public ?string $description;

    public function __construct(User $user, Address $address, string $planId, string $device, string $type, ?string $description = null)
    {
        if (!in_array($device, ['android', 'ios'])) {
            throw new InvalidArgumentException('The device parameter invalid value(android/ios): '.$device);
        }
        if (!in_array($type, ['START', 'END'])) {
            throw new InvalidArgumentException('The type parameter invalid value(START/END): '.$type);
        }
        $this->user = $user;
        $this->address = $address;
        $this->planId = $planId;
        $this->device = ucfirst($device);
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
        return array_merge($this->address->serialize(), [
            'type' => $this->type,
            'device' => $this->device,
            'planId' => $this->planId,
            'description' => $this->description,
        ]);
    }
}
