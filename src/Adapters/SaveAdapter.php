<?php

namespace Laradocs\Moguding\Adapters;

use Laradocs\Moguding\Params\Save;

class SaveAdapter
{
    /**
     * 用户 ID
     *
     * @var int
     */
    public int $userId;

    /**
     * 详细地址
     *
     * @var string
     */
    public string $address;

    /**
     * 打卡类型
     *
     * @var string
     */
    public string $type;

    /**
     * 操作系统
     *
     * @var string
     */
    public string $system;

    /**
     * 计划 ID
     *
     * @var string
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
