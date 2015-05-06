<?php

namespace WZRD\Test\Push;

use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class NotificationTest extends PHPUnit_Framework_TestCase
{
    public function test_notification_set_get()
    {
        // Describe the notification
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(['id_article' => 1568]);
        $notification->addDevices('ios', ['token1', 'token2'], ['sound' => 'goal.aif']);
        $notification->addDevices('gcm', ['token3', 'token4'], ['title' => 'But !']);
        $notification->addDevices('ios', ['token3'], ['sound' => 'goal2.aif']);

        // Tests
        $this->assertEquals('3-0 pour le RCL !', $notification->getMessage());
        $this->assertEquals(['id_article' => 1568], $notification->getData());
        $this->assertEquals(['ios', 'gcm'], $notification->getTargetedPlatforms());
        $devices_expected = [
            'ios' => [
                'devices' => ['token1', 'token2', 'token3'],
                'options' => ['sound' => 'goal2.aif'],
            ],
            'gcm' => [
                'devices' => ['token3', 'token4'],
                'options' => ['title' => 'But !'],
            ],
        ];
        $this->assertEquals($devices_expected, $notification->getDevices());
    }
}
