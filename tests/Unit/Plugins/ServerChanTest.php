<?php

namespace Unit\Plugins;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Laradocs\Moguding\Exceptions\MissingArgumentException;
use Laradocs\Moguding\Exceptions\SendKeyInvalidException;
use Laradocs\Moguding\Plugins\ServerChan;
use PHPUnit\Framework\TestCase;
use Mockery;

class ServerChanTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testKeyInvalidException()
    {
        $this->expectException(SendKeyInvalidException::class);

        $server = new ServerChan('xxxx');
        $server->title('测试标题')->send();
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

    public function testSendWithTitleIsNullInvalid()
    {
        $this->expectException(MissingArgumentException::class);
        $this->expectExceptionMessage('The title parameter is required');

        $server = new ServerChan('mock-key');
        $server->send();
    }

    protected function client(): Client
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($url) {
            if (str_contains($url, 'ftqq')) {
                $body = file_get_contents(__DIR__.'/../../json/ftqq.json');
            }

            return new Response(body: $body);
        });

        return $client;
    }
}
