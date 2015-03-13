<?php

namespace Wzrd\Framework\Push;

use Parse\ParsePush;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseInstallation;
use Wzrd\Contracts\Push\Pusher;
use Wzrd\Contracts\Push\Notification as NotificationContract;

class ParsePusher implements Pusher
{
    /**
     * Push message.
     *
     * @param  Wzrd\Contracts\Push\Notification  $notification
     * @param  array  $options
     *
     * Parse's specifics options :
     * <code>
     * $array = array(
     *     'parse_query' => ParseInstallation::query(),
     *     'parse_channels' => array('channel1', 'channel2'),
     *     'parse_expiration_time' => new DateTime(),
     *     'parse_push_time' => new DateTime()
     * );
     * </code>
     */
    public function push(NotificationContract $notification, array $options = array())
    {
        if(count(array_intersect($notification->getTargetedPlatforms(), $this->getSupportedPlatforms())) > 0) {

            if(empty($options['parse_query'])) {
                // Initialize the query
                $query = $this->parseQuery();

                // Targetted devices
                $devices = array();
                foreach($notification->getDevices() as $platform) {
                    $devices = array_merge($devices, $platform['devices']);
                }

                $query->equalTo('deviceToken', $devices);
            }
            else {
                $query = $options['parse_query'];
            }

            // Push
            $this->parsePushSend(array(
                "where" => $query,
                "channels" => !empty($options['parse_channels']) ? $options['parse_channels'] : null,
                "expiration_time" => !empty($options['parse_expiration_time']) ? $options['parse_expiration_time'] : null,
                "push_time" => !empty($options['parse_push_time']) ? $options['parse_push_time'] : null,
                "data" => $notification->getData(),
                "alert" => $notification->getMessage()
            ));
        }
    }

    /**
     * Create Parse query
     *
     * @return Parse\ParseQuery
     */
    protected function parseQuery()
    {
        return ParseInstallation::query();
    }

    /**
     * Do Parse Push
     *
     * @param  array $data
     */
    protected function parsePushSend($data)
    {
        ParsePush::send($data);
    }

    /**
     * Get supported platforms
     *
     * @return  array
     */
    public function getSupportedPlatforms()
    {
        return ['ios', 'android', 'winphone'];
    }
}
