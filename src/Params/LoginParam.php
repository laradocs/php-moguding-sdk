<?php

namespace Laradocs\Moguding\Params;

use GuzzleHttp\RequestOptions;

class LoginParam
{
    /**
     * 登录实例
     *
     * @var Login
     */
    protected Login $login;

    public function __construct(Login $login)
    {
        $this->login = $login;
    }

    /**
     * 请求体
     *
     * @return array
     */
    public function body(): array
    {
        return [
            RequestOptions::JSON => $this->login->serialize(),
        ];
    }
}
