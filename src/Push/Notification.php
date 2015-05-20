<?php

namespace WZRD\Push;

use WZRD\Contracts\Push\Notification as NotificationContract;

class Notification implements NotificationContract
{
    /**
     * Message.
     *
     * @var string
     */
    protected $message;

    /**
     * Data.
     *
     * @var array
     */
    protected $data;

    /**
     * Devices.
     *
     * @var array
     */
    protected $devices;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->message = '';
        $this->data    = $this->devices    = [];
    }

    /**
     * Set the notification's message.
     *
     * @param string $message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get notification's message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the notification's data.
     *
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get notification's data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Add a platform to the notification.
     *
     * @param string $platform
     * @param array  $platform
     * @param array  $options  Optional
     *
     * @return self
     */
    public function addDevices($platform, array $devices, array $options = [])
    {
        $data = ['devices' => $devices, 'options' => $options];

        if (!empty($this->devices[$platform])) {
            $this->devices[$platform]['devices'] = array_merge($this->devices[$platform]['devices'], $data['devices']);
            $this->devices[$platform]['options'] = array_merge($this->devices[$platform]['options'], $data['options']);
        } else {
            $this->devices[$platform] = $data;
        }

        return $this;
    }

    /**
     * Get devices tokens.
     *
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Get targeted platforms.
     *
     * @return array
     */
    public function getTargetedPlatforms()
    {
        return array_keys($this->devices);
    }
}
