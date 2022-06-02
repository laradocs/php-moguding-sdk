<?php

namespace Laradocs\Moguding\Traits;

trait HasSignature
{
    protected string $salt = '3478cbbc33f84bd00d75d7dfa69e0daa';

    protected function planSign(int $id, string $type): string
    {
        return md5(
            sprintf('%d%s%s', $id, $type, $this->salt)
        );
    }

    protected function saveSign(string $device, string $type, string $planId, int $userId, string $address)
    {
        return md5(
            sprintf('%s%s%s%d%s%s', $device, $type, $planId, $userId, $address, $this->salt)
        );
    }
}
