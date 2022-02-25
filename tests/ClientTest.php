<?php

namespace Laradocs\Moguding\Tests;

use Laradocs\Moguding\Client;
use PHPUnit\Framework\TestCase;
use Mockery;

class ClientTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testLogin()
    {
        $factory = Mockery::mock(Client::class);
        $factory->shouldReceive('login')->andReturn(json_decode(file_get_contents(__DIR__ . '/login.json'), true));
        $data = $factory->login('xxx', 'xxx', 'xxx');

        $this->assertNotEmpty($data);
        $this->assertSame(200, $data ['code']);
    }

    public function testGetPlan()
    {
        $factory = Mockery::mock(Client::class);
        $factory->shouldReceive('getPlan')->andReturn(json_decode(file_get_contents(__DIR__ . '/get_plan_by_stu.json'), true));
        $data = $factory->getPlan('123456', 'student', '10000');

        $this->assertSame(200, $data ['code']);
    }

    public function testSave()
    {
        $factory = Mockery::mock(Client::class);
        $factory->shouldReceive('save')->andReturn(json_decode(file_get_contents(__DIR__ . '/save.json'), true));
        $data = $factory->save('123456', '10000', 'xxx', 'xxx', 'xxxxxxxxxx', 100.000000, 10.000000, 'xxx', 'xxxx', '987654');

        $this->assertNotEmpty($data);
        $this->assertSame(200, $data ['code']);
    }


    /**
     * @doesNotPerformAssertions
     */
    public function testSctSend()
    {
        $factory = Mockery::mock(Client::class);
        $factory->shouldReceive('sctSend');
        $factory->sctSend('xxx', '标题', '后文');
    }
}
