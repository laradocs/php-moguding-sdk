<?php

namespace Unit\Plugins;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Laradocs\Moguding\Exceptions\InvalidArgumentException;
use Laradocs\Moguding\Plugins\ServerChan;
use PHPUnit\Framework\TestCase;
use Mockery;

class ServerChanTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testSend()
    {
        $server = Mockery::mock(ServerChan::class, ['mock-key'])->makePartial();
        $server->shouldReceive('getHttpClient')->andReturn($this->client());
        $response = $server
            ->title('测试标题')
            ->desp('测试正文')
            ->channel([0, 1])
            ->send();

        $this->assertNotEmpty($response);
        $this->assertSame(0, $response['code']);
    }

    public function testSendWithTitleIsNullException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The title parameter invalid value');

        $server = new ServerChan('mock-key');
        $server->send();
    }

    protected function client(): Client
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($url) {
            if (str_contains($url, 'ftqq')) {
                $body = file_get_contents(__DIR__ . '/../../json/ftqq.json');
            }

            return new Response(body: $body);
        });

        return $client;
    }
}