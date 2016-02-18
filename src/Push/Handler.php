<?php

namespace WZRD\Push;

use WZRD\Contracts\Push\Notification as NotificationContract;
use WZRD\Contracts\Push\Pusher;

class Handler implements Pusher
{
    /**
     * Pushers.
     *
     * @var WZRD\Contracts\Push\Pusher[]
     */
    protected $pushers;

    /**
     * Construct with pushers instances.
     *
     * @param WZRD\Contracts\Push\Pusher[] $pushers
     */
    public function __construct(array $pushers)
    {
        $this->pushers = $pushers;
    }

    /**
     * Push message.
     *
     * @param WZRD\Contracts\Push\Notification $notification
     * @param array                            $options
     */
    public function push(NotificationContract $notification, array $options = [])
    {
        foreach ($this->pushers as $pusher) {
            if ($pusher instanceof Pusher) {
                $pusher->push($notification, $options);
            }
        }
    }

    /**
     * Get supported platforms.
     *
     * @return array
     */
    public function getSupportedPlatforms()
    {
        $platforms = [];

        foreach ($this->pushers as $pusher) {
            if ($pusher instanceof Pusher) {
                $platforms = array_merge($platforms, $pusher->getSupportedPlatforms());
            }
        }

        return array_unique($platforms);
    }
}
