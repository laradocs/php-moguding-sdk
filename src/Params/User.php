<?php

namespace Laradocs\Moguding\Params;

use Laradocs\Moguding\Exceptions\InvalidArgumentException;

class User
{
    /**
     * 用户 Token.
     */
    public string $token;

    /**
     * 用户 ID.
     */
    public int $id;

    /**
     * 用户类型.
     */
    public string $type;

    public function __construct(string $token, int $id, string $type)
    {
        if (!in_array($type, ['teacher', 'student'])) {
            throw new InvalidArgumentException('The type parameter invalid value(teacher/student): '.$type);
        }

        $this->token = $token;
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * 序列化.
     *
     * @return array
     */
    public function serialize()
    {
        return [
            'token' => $this->token,
            'userId' => $this->id,
            'userType' => $this->type,
        ];
    }
}
