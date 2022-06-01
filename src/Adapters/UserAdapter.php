<?php

namespace Laradocs\Moguding\Adapters;

use Laradocs\Moguding\Params\User;

class UserAdapter
{
    /**
     * 用户 ID.
     */
    public int $id;

    /**
     * 用户类型.
     */
    public string $type;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->type = $user->type;
    }
}
