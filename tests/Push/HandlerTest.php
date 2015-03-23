<?php

namespace WZRD\Test\Push;

use Mockery;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class HandlerTest extends PHPUnit_Framework_TestCase
{
    public function test_send()
    {
        // Setup mailers
        $pusher1 = $pusher2 = Mockery::mock('WZRD\Contracts\Push\Pusher')->makePartial();
        $pushers = array($pusher1, $pusher2, new \StdClass());
        $pusher1->shouldReceive('getSupportedPlatforms')->andReturn(['ios', 'blackberry']);
        $pusher2->shouldReceive('getSupportedPlatforms')->andReturn(['ios']);

        // Configure handler
        $handler = new Framework\Push\Handler($pushers);

        // Prepare message
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(array('id_article' => 1568));
        $notification->addDevices('ios', ['token1', 'token2'], array('sound' => 'goal.aif'));
        $notification->addDevices('gcm', ['token3', 'token4'], array('title' => 'But !'));

        // Prepare test
        $pusher1->shouldReceive('push')->with($notification, array())->once();
        $pusher2->shouldReceive('push')->with($notification, array())->once();

        // Send !
        $handler->push($notification);

        // Test platforms supported
        $this->assertEquals(['ios', 'blackberry'], $handler->getSupportedPlatforms());
    }
}
