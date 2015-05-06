<?php

namespace WZRD\Test\Push;

use Mockery;
use Datetime;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class ParsePusherTest extends PHPUnit_Framework_TestCase
{
    public function test_push_unknown_platform()
    {
        // Prepare pusher
        $pusher = Mockery::mock('WZRD\Push\ParsePusher[parseQuery,parsePushSend]')->shouldAllowMockingProtectedMethods();

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->addDevices('unknown', ['token5'], ['options1' => 'value']);

        // Push the notification
        $this->assertNull($pusher->push($notification));
    }

    public function test_push()
    {
        $date1 = new Datetime();
        $date2 = new Datetime('tomorrow');

        // Prepare pusher
        $pusher = Mockery::mock('WZRD\Push\ParsePusher[parseQuery,parsePushSend]')->shouldAllowMockingProtectedMethods();

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(['id_article' => 1568]);
        $notification->addDevices('ios', ['token1', 'token2'], ['sound' => 'goal.aif']);
        $notification->addDevices('android', ['token3', 'token4'], ['title' => 'But !']);
        $notification->addDevices('unknown', ['token5'], ['options1' => 'value']);

        // Mock query
        $query = Mockery::mock('Parse\ParseQuery')->makePartial();
        $query->shouldReceive('equalTo')->with('deviceToken', ['token1', 'token2', 'token3', 'token4'])->once();

        // Mock pusher
        $pusher->shouldReceive('parseQuery')->andReturn($query)->once();
        $pusher->shouldReceive('parsePushSend')->with([
            "where"           => $query,
            "channels"        => ['channel1', 'channel2'],
            "expiration_time" => $date1,
            "push_time"       => $date2,
            "data"            => ['id_article' => 1568, 'sound' => 'goal.aif', 'title' => 'But !'],
            "alert"           => $notification->getMessage(),
        ])->once();

        // Push the notification
        $pusher->push($notification, [
            'parse_channels'        => ['channel1', 'channel2'],
            'parse_expiration_time' => $date1,
            'parse_push_time'       => $date2,
        ]);
    }

    public function test_custom_query()
    {
        // Prepare pusher
        $pusher = Mockery::mock('WZRD\Push\ParsePusher[parseQuery,parsePushSend]')->shouldAllowMockingProtectedMethods();

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(['id_article' => 1568]);
        $notification->addDevices('ios', ['token1', 'token2'], ['sound' => 'goal.aif']);
        $notification->addDevices('android', ['token3', 'token4'], ['title' => 'But !']);
        $notification->addDevices('unknown', ['token5'], ['options1' => 'value']);

        // Mock query
        $query = Mockery::mock('Parse\ParseQuery')->makePartial();

        // Mock pusher
        $pusher->shouldReceive('parsePushSend')->with([
            "where"           => $query,
            "channels"        => null,
            "expiration_time" => null,
            "push_time"       => null,
            "data"            => ['id_article' => 1568, 'sound' => 'goal.aif', 'title' => 'But !'],
            "alert"           => $notification->getMessage(),
        ])->once();

        // Push the notification
        $pusher->push($notification, ['parse_query' => $query]);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
