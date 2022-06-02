<?php

namespace Laradocs\Moguding\Params;

use Laradocs\Moguding\Exceptions\InvalidArgumentException;

class Login
{
    /**
     * 操作设备
     */
    public string $device;

    /**
     * 手机号码
     */
    public int $phone;

    /**
     * 密码
     */
    public string $password;

    public function __construct(string $device, int $phone, string $password)
    {
        if (!in_array($device, ['android', 'ios'])) {
            throw new InvalidArgumentException('The device parameter invalid value(android/ios): '. $device);
        }
        if (11 !== strlen($phone)) {
            throw new InvalidArgumentException('The phone parameter length must be 11 digits');
        }

        $this->device = $device;
        $this->phone = $phone;
        $this->password = $password;
    }

    /**
     * 序列化.
     */
    public function serialize(): array
    {
        return [
            'loginType' => $this->device,
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }
}
