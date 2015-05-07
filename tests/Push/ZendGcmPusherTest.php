<?php

namespace WZRD\Test\Push;

use Mockery;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;
use ZendService\Google\Gcm\Message;

class ZendGcmPusherTest extends PHPUnit_Framework_TestCase
{
    public function test_push_unknown_platform()
    {
        // Prepare pusher
        $pusher = Mockery::mock('WZRD\Push\ZendGcmPusher')->makePartial();

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->addDevices('unknown', ['token5'], ['options1' => 'value']);

        // Push the notification
        $this->assertNull($pusher->push($notification));
    }

    public function test_push()
    {
        // Prepare pusher
        $client = Mockery::mock('ZendService\Google\Gcm\Client')->makePartial();
        $pusher = new Framework\Push\ZendGcmPusher($client);

        // Compose notification
        $notification = new Framework\Push\Notification();
        $notification->setMessage('3-0 pour le RCL !');
        $notification->setData(['id_article' => 1568]);
        $notification->addDevices('android', ['token1', 'token2'], [
            'ttl'                     => 3600,
            'dry_run'                 => true,
            'delay_while_idle'        => true,
            'restricted_package_name' => 'app.fr',
            'collapse_key'            => 'key',
        ]);
        $notification->addDevices('unknown', ['token5'], ['options1' => 'value']);

        // Message expected
        $message_expected = new Message();
        $message_expected->setRegistrationIds(['token1', 'token2']);
        $message_expected->setData([
            'id_article' => 1568,
            'message'    => '3-0 pour le RCL !',
        ]);
        $message_expected->setCollapseKey('key');
        $message_expected->setRestrictedPackageName('app.fr');
        $message_expected->setDelayWhileIdle(true);
        $message_expected->setTimeToLive('3600');
        $message_expected->setDryRun(true);

        // Mock pusher
        $client->shouldReceive('send')->with(Mockery::on(function ($value) use ($message_expected) {
            return $value == $message_expected;
        }))->once();

        $client->shouldReceive('send');

        // Push the notification
        $pusher->push($notification);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
