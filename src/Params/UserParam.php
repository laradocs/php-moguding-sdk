<?php

namespace Laradocs\Moguding\Params;

use GuzzleHttp\RequestOptions;
use Laradocs\Moguding\Adapters\UserAdapter;
use Laradocs\Moguding\Traits\HasSignature;

class UserParam
{
    use HasSignature;

    /**
     * 用户实例
     *
     * @var User
     */
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 请求体
     *
     * @return array
     */
    public function body(): array
    {
        return [
            RequestOptions::HEADERS => [
                'Authorization' => $this->user->token,
            ],
            RequestOptions::JSON => [
                'roleKey' => $this->user->type,
                'sign' => $this->planSign(new UserAdapter($this->user)),
            ],
        ];
    }
}
