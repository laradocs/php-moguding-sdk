<?php

namespace Laradocs\Moguding\Extensions;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use Laradocs\Moguding\Exceptions\SendKeyInvalidException;

class Notification
{
    public function client(string $url): Guzzle
    {
        $config = [
            'base_uri' => $url,
            'timeout' => 1.5,
        ];
        $factory = new Guzzle($config);

        return $factory;
    }

    /**
     * Server Chan
     *
     * @link https://sct.ftqq.com
     *
     * @param string|null $sendKey
     * @param string|null $title
     * @param string|null $desp
     *
     * @return void
     */
    public function sct(?string $sendKey = null, ?string $title = null, ?string $desp = null): void
    {
        if (is_null($sendKey)) {
            return;
        }
        try {
            $this->client('https://sctapi.ftqq.com')
                ->post("{$sendKey}.send", [
                    'form_params' => [
                        'title' => $title,
                        'desp' => $desp,
                    ],
                ]);
        } catch (GuzzleException) {
            echo '[Server 酱] 通知推送 SendKey 配置失效。' . PHP_EOL;
        }
    }
}
