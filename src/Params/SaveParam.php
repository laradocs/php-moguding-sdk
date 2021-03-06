<?php

namespace Laradocs\Moguding\Params;

use GuzzleHttp\RequestOptions;
use Laradocs\Moguding\Traits\HasSignature;

class SaveParam
{
    use HasSignature;

    /**
     * 保存实例.
     */
    public Save $save;

    public function __construct(Save $save)
    {
        $this->save = $save;
    }

    /**
     * 请求体.
     *
     * @return array
     */
    public function body()
    {
        return [
            RequestOptions::HEADERS => [
                'Authorization' => $this->save->user->token,
                'sign' => $this->saveSign($this->save->device, $this->save->type, $this->save->planId, $this->save->user->id, $this->save->address->address),
            ],
            RequestOptions::JSON => $this->save->serialize(),
        ];
    }
}
