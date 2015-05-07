<?php

namespace WZRD\Push;

use Zend\Http\Client as Http;
use WZRD\Contracts\Push\Pusher;
use ZendService\Google\Gcm\Client;
use ZendService\Google\Gcm\Message;
use WZRD\Contracts\Push\Notification as NotificationContract;

class ZendGcmPusher implements Pusher
{
    /**
     * Zend GCM.
     *
     * @var ZendService\Google\Gcm\Client
     */
    private $client;

    /**
     * Construct with Zend GCM Client instance.
     *
     * @param ZendService\Google\Gcm\Client $client
     */
    public function __construct(Client $client)
    {
        $client->setHttpClient(new Http(null, [
            'adapter'       => 'Zend\Http\Client\Adapter\Socket',
            'sslverifypeer' => false,
        ]));

        $this->client = $client;
    }

    /**
     * Push message.
     *
     * @param WZRD\Contracts\Push\Notification $notification
     * @param array                            $options
     */
    public function push(NotificationContract $notification, array $options = [])
    {
        // Check the supported platforms
        if (count(array_intersect($notification->getTargetedPlatforms(), $this->getSupportedPlatforms())) == 0) {
            return;
        }

        // Platforms & devices options
        $devices = $platforms_options = [];
        foreach ($notification->getDevices() as $platform => $data) {
            if (in_array($platform, $this->getSupportedPlatforms())) {
                $platforms_options = array_merge($platforms_options, $data['options']);
                $devices           = array_merge($devices, $data['devices']);
            }
        }

        // Prepare message
        $message = new Message();
        $message->setRegistrationIds($devices);
        $message->setData(array_merge($notification->getData(), [
            'message' => $notification->getMessage(),
        ]));

        if (!empty($platforms_options['collapse_key'])) {
            $message->setCollapseKey($platforms_options['collapse_key']);
        }

        if (!empty($platforms_options['restricted_package_name'])) {
            $message->setRestrictedPackageName($platforms_options['restricted_package_name']);
        }

        if (!empty($platforms_options['delay_while_idle'])) {
            $message->setDelayWhileIdle(true);
        }

        if (!empty($platforms_options['ttl'])) {
            $message->setTimeToLive($platforms_options['ttl']);
        }

        if (!empty($platforms_options['dry_run'])) {
            $message->setDryRun(true);
        }

        $this->client->send($message);
    }

    /**
     * Get supported platforms.
     *
     * @return array
     */
    public function getSupportedPlatforms()
    {
        return ['android'];
    }
}
