<?php

namespace Laradocs\Moguding\Params;

use GuzzleHttp\RequestOptions;
use Laradocs\Moguding\Traits\HasSignature;

class UserParam
{
    use HasSignature;

    /**
     * 用户实例.
     */
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 请求体.
     */
    public function body(): array
    {
        return [
            RequestOptions::HEADERS => [
                'Authorization' => $this->user->token,
            ],
            RequestOptions::JSON => [
                'roleKey' => $this->user->type,
                'sign' => $this->planSign($this->user->id, $this->user->type),
            ],
        ];
    }
}
