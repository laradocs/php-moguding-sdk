<?php

namespace Laradocs\Moguding\Plugins;

use Exception;
use GuzzleHttp\RequestOptions;
use Laradocs\Moguding\Exceptions\InvalidArgumentException;
use Laradocs\Moguding\Exceptions\SendKeyInvalidException;
use Laradocs\Moguding\Utils\Json;

class ServerChan extends Channel
{
    /**
     * 消息标题.
     */
    protected string $title;

    /**
     * 消息正文.
     */
    protected ?string $desp = null;

    /**
     * 推送通道.
     */
    protected ?string $channel = null;

    /**
     * 设置消息标题.
     *
     * @return $this
     */
    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * 设置消息正文.
     *
     * @return $this
     */
    public function desp(string $desp): self
    {
        $this->desp = $desp;

        return $this;
    }

    /**
     * 设置推送通道.
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function channel(array $channels): self
    {
        if (null != $channels && count($channels) > 2) {
            throw new InvalidArgumentException('The channels parameter invalid value');
        }

        $this->channel = implode('|', $channels);

        return $this;
    }

    /**
     * 发送通知.
     */
    public function send(): array
    {
        if (empty($this->key)) {
            return [];
        }
        if (!isset($this->title)) {
            throw new InvalidArgumentException('The title parameter invalid value');
        }

        $uri = "https://sctapi.ftqq.com/{$this->key}.send";
        try {
            $response = $this->getHttpClient()
                ->post($uri, [
                    RequestOptions::JSON => [
                        'title' => $this->title,
                        'desp' => $this->desp,
                        'channel' => $this->channel,
                    ],
                ])
                ->getBody()
                ->getContents();

            return Json::decode($response);
        } catch (Exception $e) {
            throw new SendKeyInvalidException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
