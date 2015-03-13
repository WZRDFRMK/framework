<?php

namespace Wzrd\Framework\Test\Push;

use Mockery;
use PHPUnit_Framework_TestCase;
use Wzrd\Framework as Framework;

class NotificationTest extends PHPUnit_Framework_TestCase
{
    public function test_notification_set_get()
    {
        // Describe the notification
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(array('id_article' => 1568));
        $notification->addDevices('ios', ['token1', 'token2'], array('sound' => 'goal.aif'));
        $notification->addDevices('gcm', ['token3', 'token4'], array('title' => 'But !'));
        $notification->addDevices('ios', ['token3'], array('sound' => 'goal2.aif'));

        // Tests
        $this->assertEquals('3-0 pour le RCL !', $notification->getMessage());
        $this->assertEquals(['id_article' => 1568], $notification->getData());
        $this->assertEquals(['ios', 'gcm'], $notification->getTargetedPlatforms());
        $devices_expected = array(
            'ios' => array(
                'devices' => array('token1', 'token2', 'token3'),
                'options' => array('sound' => 'goal2.aif')
            ),
            'gcm' => array(
                'devices' => array('token3', 'token4'),
                'options' => array('title' => 'But !')
            )
        );
        $this->assertEquals($devices_expected, $notification->getDevices());
    }
}
