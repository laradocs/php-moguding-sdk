<?php

namespace Laradocs\Moguding\Params;

use Laradocs\Moguding\Exceptions\InvalidArgumentException;

class Login
{
    /**
     * 操作系统
     *
     * @var string
     */
    public string $system;

    /**
     * 手机号码
     *
     * @var int
     */
    public int $phone;

    /**
     * 密码
     *
     * @var string
     */
    public string $password;

    public function __construct(string $system, int $phone, string $password)
    {
        if (! in_array($system, ['android', 'ios'])) {
            throw new InvalidArgumentException('The system parameter invalid value(android/ios): ' . $system);
        }
        if (strlen($phone) !== 11) {
            throw new InvalidArgumentException('The phone parameter length must be 11 digits');
        }

        $this->system = $system;
        $this->phone = $phone;
        $this->password = $password;
    }

    /**
     * 序列化
     *
     * @return array
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
