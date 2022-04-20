<?php

namespace Tests\Unit\Extensions;

use Laradocs\Moguding\Extensions\Notification;
use PHPUnit\Framework\TestCase;
use Mockery;

class NotificationTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testSct()
    {
        $factory = Mockery::mock(Notification::class);
        $factory->shouldReceive('sct');
        $factory->sct('xxx', 'xxx', 'xxx');
    }
}