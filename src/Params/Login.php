<?php

namespace Laradocs\Moguding\Params;

use Laradocs\Moguding\Exceptions\InvalidArgumentException;

class Login
{
    /**
     * 操作系统
     */
    public string $system;

    /**
     * 手机号码
     */
    public int $phone;

    /**
     * 密码
     */
    public string $password;

    public function __construct(string $system, int $phone, string $password)
    {
        if (!in_array($system, ['android', 'ios'])) {
            throw new InvalidArgumentException('The system parameter invalid value(android/ios): '.$system);
        }
        if (11 !== strlen($phone)) {
            throw new InvalidArgumentException('The phone parameter length must be 11 digits');
        }

        $this->system = $system;
        $this->phone = $phone;
        $this->password = $password;
    }

    /**
     * 序列化.
     */
    public function serialize(): array
    {
        return [
            'loginType' => $this->system,
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }
}
