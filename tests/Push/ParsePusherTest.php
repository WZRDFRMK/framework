<?php

namespace Wzrd\Test\Push;

use Mockery;
use Datetime;
use Parse\ParseInstallation;
use PHPUnit_Framework_TestCase;
use Wzrd as Framework;

class ParsePusherTest extends PHPUnit_Framework_TestCase
{
    public function test_push()
    {
        $date1 = new Datetime();
        $date2 = new Datetime('tomorrow');

        // Prepare pusher
        $pusher = Mockery::mock('Wzrd\Push\ParsePusher[parseQuery,parsePushSend]')->shouldAllowMockingProtectedMethods();

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(array('id_article' => 1568));
        $notification->addDevices('ios', ['token1', 'token2'], array('sound' => 'goal.aif'));
        $notification->addDevices('gcm', ['token3', 'token4'], array('title' => 'But !'));

        // Mock query
        $query = Mockery::mock('Parse\ParseQuery')->makePartial();
        $query->shouldReceive('equalTo')->with('deviceToken', ['token1', 'token2', 'token3', 'token4'])->once();

        // Mock pusher
        $pusher->shouldReceive('parseQuery')->andReturn($query)->once();
        $pusher->shouldReceive('parsePushSend')->with(array(
            "where" => $query,
            "channels" => array('channel1', 'channel2'),
            "expiration_time" => $date1,
            "push_time" => $date2,
            "data" => $notification->getData(),
            "alert" => $notification->getMessage()
        ))->once();

        // Push the notification
        $pusher->push($notification, array(
            'parse_channels' => array('channel1', 'channel2'),
            'parse_expiration_time' => $date1,
            'parse_push_time' => $date2
        ));
    }

    public function test_custom_query()
    {
        // Prepare pusher
        $pusher = Mockery::mock('Wzrd\Push\ParsePusher[parseQuery,parsePushSend]')->shouldAllowMockingProtectedMethods();

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(array('id_article' => 1568));
        $notification->addDevices('ios', ['token1', 'token2'], array('sound' => 'goal.aif'));
        $notification->addDevices('gcm', ['token3', 'token4'], array('title' => 'But !'));

        // Mock query
        $query = Mockery::mock('Parse\ParseQuery')->makePartial();

        // Mock pusher
        $pusher->shouldReceive('parsePushSend')->with(array(
            "where" => $query,
            "channels" => null,
            "expiration_time" => null,
            "push_time" => null,
            "data" => $notification->getData(),
            "alert" => $notification->getMessage()
        ))->once();

        // Push the notification
        $pusher->push($notification, array('parse_query' => $query));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
