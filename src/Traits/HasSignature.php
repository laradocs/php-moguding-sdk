<?php

namespace Laradocs\Moguding\Traits;

use Laradocs\Moguding\Adapters\SaveAdapter;
use Laradocs\Moguding\Adapters\UserAdapter;

trait HasSignature
{
    protected string $salt = '3478cbbc33f84bd00d75d7dfa69e0daa';

    protected function planSign(UserAdapter $adapter): string
    {
        return md5(
            sprintf('%d%s%s', $adapter->id, $adapter->type, $this->salt)
        );
    }

    protected function saveSign(SaveAdapter $adapter): string
    {
        return md5(
            sprintf('%s%s%s%d%s%s', $adapter->system, $adapter->type, $adapter->planId, $adapter->userId, $adapter->address, $this->salt)
        );
    }
}
