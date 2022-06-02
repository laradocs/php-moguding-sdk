<?php

namespace Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Laradocs\Moguding\Exceptions\InvalidArgumentException;
use Laradocs\Moguding\Moguding;
use Laradocs\Moguding\Params\Address;
use Laradocs\Moguding\Params\Login;
use Laradocs\Moguding\Params\LoginParam;
use Laradocs\Moguding\Params\Save;
use Laradocs\Moguding\Params\SaveParam;
use Laradocs\Moguding\Params\User;
use Laradocs\Moguding\Params\UserParam;
use Mockery;
use PHPUnit\Framework\TestCase;

class MogudingTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testLogin()
    {
        $login = new Login('android', 13888888888, '123456');

        $this->assertSame([
            'loginType' => 'android',
            'phone' => 13888888888,
            'password' => '123456',
        ], $login->serialize());
    }

    public function testLoginWithDeviceInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The device parameter invalid value(android/ios): os');

        new Login('os', 1388888888, '123456');
    }

    public function testLoginWithPhoneInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The phone parameter length must be 11 digits');

        new Login('ios', 1388888888, '123456');
    }

    public function testUser()
    {
        $user = new User('mock-token', 1300000, 'student');

        $this->assertSame([
            'token' => 'mock-token',
            'userId' => 1300000,
            'userType' => 'student',
        ], $user->serialize());
    }

    public function testUserWithTypeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The type parameter invalid value(teacher/student): example');

        new User('mock-token', 1300000, 'example');
    }

    public function testAddress(): void
    {
        $address = new Address('上海市', null, '长宁区xxxxxxxxxx', 200.200000, 20.00000);

        $this->assertSame([
            'province' => '上海市',
            'address' => '长宁区xxxxxxxxxx',
            'longitude' => 200.200000,
            'latitude' => 20.00000,
            'country' => '中国',
        ], $address->serialize());
    }

    public function testSave()
    {
        $save = new Save(
            new User('mock-token', 1300000, 'student'),
            new Address('上海市', null, '长宁区xxxxxxxxxx', 200.200000, 20.00000),
            'mock-planId',
            'android',
            'START'
        );

        $this->assertSame([
            'country' => '中国',
            'province' => '上海市',
            'address' => '长宁区xxxxxxxxxx',
            'longitude' => 200.200000,
            'latitude' => 20.00000,
            'planId' => 'mock-planId',
            'device' => 'Android',
            'type' => 'START',
        ], $save->serialize());
    }

    public function testSaveWithDeviceInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The device parameter invalid value(android/ios): os');

        new Save(
            new User('mock-token', 1300000, 'student'),
            new Address('上海市', null, '长宁区xxxxxxxxxx', 200.200000, 20.00000),
            'END',
            'os',
            'mock-planId'
        );
    }

    public function testSaveWithTypeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The type parameter invalid value(START/END): foo');

        new Save(
            new User('mock-token', 1300000, 'student'),
            new Address('上海市', null, '长宁区xxxxxxxxxx', 200.200000, 20.00000),
            'mock-planId',
            'android',
            'foo'
        );
    }

    public function testGetUserProfile()
    {
        $moguding = Mockery::mock(Moguding::class)->makePartial();
        $moguding->shouldReceive('getHttpClient')->andReturn($this->client());
        $response = $moguding->getUserProfile(new LoginParam(
            new Login(
                'android',
                13888888888,
                'mock-password'
            )
        ));

        $this->assertNotEmpty($response);
        $this->assertSame('10000', $response['userId']);
    }

    public function testGetPlanList()
    {
        $moguding = Mockery::mock(Moguding::class)->makePartial();
        $moguding->shouldReceive('getHttpClient')->andReturn($this->client());
        $response = $moguding->getPlanList(new UserParam(
            new User('mock-token', 1300000, 'student')
        ));

        $this->assertNotEmpty($response);
        $this->assertSame(0, $response[0]['totalCount']);
    }

    public function testGetSaveInfo()
    {
        $moguding = Mockery::mock(Moguding::class)->makePartial();
        $moguding->shouldReceive('getHttpClient')->andReturn($this->client());
        $response = $moguding->getSaveInfo(new SaveParam(
            new Save(
                new User('mock-token', 1300000, 'teacher'),
                new Address('上海市', null, '长宁区xxxxxxxxxx', 200.200000, 20.00000),
                'mock-planId',
                'android',
                'START'
            )
        ));

        $this->assertNotEmpty($response);
        $this->assertSame('2022-01-15 11:35:58', $response['createTime']);
    }

    protected function client(): Client
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($url) {
            if (str_contains($url, 'login')) {
                $body = file_get_contents(__DIR__.'/../json/login.json');
            }
            if (str_contains($url, 'getPlanByStu')) {
                $body = file_get_contents(__DIR__.'/../json/get_plan_by_stu.json');
            }
            if (str_contains($url, 'save')) {
                $body = file_get_contents(__DIR__.'/../json/save.json');
            }

            return new Response(body: $body);
        });

        return $client;
    }
}