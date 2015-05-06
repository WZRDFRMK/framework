<?php

namespace WZRD\Push;

use WZRD\Contracts\Push\Pusher;
use ZendService\Apple\Apns\Message;
use ZendService\Apple\Apns\Client\Message as Client;
use WZRD\Contracts\Push\Notification as NotificationContract;

class ZendApnsPusher implements Pusher
{
    /**
     * Zend APNS.
     *
     * @var ZendService\Apple\Apns\Client\Message
     */
    private $client;

    /**
     * Construct with Zend APNS Client instance.
     *
     * @param ZendService\Apple\Apns\Client\Message $client
     */
    public function __construct(Client $client)
    {
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

        // Push !
        foreach ($devices as $device) {
            $message = new Message();
            $message->setToken($device);
            $message->setCustom($notification->getData());
            $message->setAlert($notification->getMessage());

            if (!empty($platforms_options['badge'])) {
                $message->setBadge($platforms_options['badge']);
            }

            if (!empty($platforms_options['sound'])) {
                $message->setSound($platforms_options['sound']);
            }

            $this->client->send($message);
        }
    }

    /**
     * Listen feedback service.
     *
     * @return array
     */
    public function feedback()
    {
        $feedback = $this->client->feedback();

        return $feedback;
    }

    /**
     * Get supported platforms.
     *
     * @return array
     */
    public function getSupportedPlatforms()
    {
        return ['ios'];
    }
}
