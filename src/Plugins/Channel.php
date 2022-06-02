<?php

namespace Laradocs\Moguding\Plugins;

use GuzzleHttp\Client;

abstract class Channel
{
    /**
     * SendKey.
     */
    protected string $key;

    /**
     * Guzzle 配置
     *
     * @var array
     */
    protected $guzzleOptions = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * 设置 Guzzle 配置
     *
     * @param array $options
     * @return void
     */
    public function setGuzzleOptions(array $options): void
    {
        $this->guzzleOptions = $options;
    }

    public function getHttpClient(): Client
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * 推送消息
     *
     * @return array
     */
    abstract public function send(): array;
}
