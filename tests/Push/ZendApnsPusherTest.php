<?php

namespace WZRD\Test\Push;

use Mockery;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;
use ZendService\Apple\Apns\Message;

class ZendApnsPusherTest extends PHPUnit_Framework_TestCase
{
    public function test_push_unknown_platform()
    {
        // Prepare pusher
        $pusher = Mockery::mock('WZRD\Push\ZendApnsPusher')->makePartial();

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->addDevices('unknown', ['token5'], ['options1' => 'value']);

        // Push the notification
        $this->assertNull($pusher->push($notification));
    }

    public function test_push()
    {
        // Prepare pusher
        $client = Mockery::mock('ZendService\Apple\Apns\Client\Message')->makePartial();
        $pusher = new Framework\Push\ZendApnsPusher($client);

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(['id_article' => 1568]);
        $notification->addDevices('ios', ['0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef', '0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdea'], ['sound' => 'goal.aif', 'badge' => 2]);
        $notification->addDevices('unknown', ['token5'], ['options1' => 'value']);

        // Message expected
        $message_expected_1 = new Message();
        $message_expected_1->setToken('0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef');
        $message_expected_1->setCustom(['id_article' => 1568]);
        $message_expected_1->setAlert('3-0 pour le RCL !');
        $message_expected_1->setBadge(2);
        $message_expected_1->setSound('goal.aif');

        $message_expected_2 = new Message();
        $message_expected_2->setToken('0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdea');
        $message_expected_2->setCustom(['id_article' => 1568]);
        $message_expected_2->setAlert('3-0 pour le RCL !');
        $message_expected_2->setBadge(2);
        $message_expected_2->setSound('goal.aif');

        // Mock pusher
        $client->shouldReceive('send')->with(Mockery::on(function ($value) use ($message_expected_1) {
            return $value == $message_expected_1;
        }))->once();

        $client->shouldReceive('send')->with(Mockery::on(function ($value) use ($message_expected_2) {
            return $value == $message_expected_2;
        }))->once();

        // Push the notification
        $pusher->push($notification);
    }

    public function test_feedback()
    {
        // Prepare pusher
        $client = Mockery::mock('ZendService\Apple\Apns\Client\Message')->makePartial();
        $pusher = new Framework\Push\ZendApnsPusher($client);

        // Mock pusher
        $client->shouldReceive('feedback')->once();

        // Get feedback
        $pusher->feedback();
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
