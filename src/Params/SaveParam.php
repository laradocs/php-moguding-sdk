<?php

namespace Laradocs\Moguding\Params;

use GuzzleHttp\RequestOptions;
use Laradocs\Moguding\Adapters\SaveAdapter;
use Laradocs\Moguding\Traits\HasSignature;

class SaveParam
{
    use HasSignature;

    /**
     * 保存实例
     *
     * @var Save
     */
    protected Save $save;

    public function __construct(Save $save)
    {
        $this->save = $save;
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
                'Authorization' => $this->save->user->token,
                'sign' => $this->saveSign(new SaveAdapter($this->save)),
            ],
            RequestOptions::JSON => $this->save->serialize(),
        ];
    }
}
