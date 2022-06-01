<?php

namespace Laradocs\Moguding\Plugins;

use GuzzleHttp\Client;

abstract class Channel
{
    /**
     * SendKey.
     */
    protected string $key;

    protected $guzzleOptions = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function setGuzzleOptions(array $options): void
    {
        $this->guzzleOptions = $options;
    }

    public function getHttpClient(): Client
    {
        return new Client($this->guzzleOptions);
    }

    abstract public function send(): array;
}
