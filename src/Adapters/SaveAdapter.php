<?php

namespace Laradocs\Moguding\Adapters;

use Laradocs\Moguding\Params\Save;

class SaveAdapter
{
    /**
     * 用户 ID.
     */
    public int $userId;

    /**
     * 详细地址
     */
    public string $address;

    /**
     * 打卡类型.
     */
    public string $type;

    /**
     * 操作系统
     */
    public string $system;

    /**
     * 计划 ID.
     */
    public string $planId;

    public function __construct(Save $save)
    {
        $this->userId = $save->user->id;
        $this->address = sprintf(
            '%s%s%s%s',
            $save->address->country,
            $save->address->province,
            $save->address->city,
            $save->address->address
        );
        $this->type = $save->type;
        $this->system = ucfirst($save->system);
        $this->planId = $save->planId;
    }
}
