<?php

namespace WZRD\Messaging;

use ArrayIterator;
use DateTime;
use WZRD\Contracts\Messaging\Message as MessageContract;

abstract class Message implements MessageContract
{
    /**
     * Get message id.
     *
     * @return string
     */
    public function getId()
    {
        if (empty($this->id)) {
            $this->id = uniqid();
        }

        return $this->id;
    }

    /**
     * Get payload.
     *
     * @return array
     */
    public function getPayload()
    {
        $iterator = new ArrayIterator(array_filter((array) $this, function ($k) {
            return $k != 'id' && $k != 'recorded_date';
        }, ARRAY_FILTER_USE_KEY));

        return (array) $iterator;
    }

    /**
     * Get the recorded date.
     *
     * @return Datetime
     */
    public function getRecordedDate()
    {
        if (empty($this->recorded_date)) {
            $this->recorded_date = new DateTime();
        }

        return $this->recorded_date;
    }

    /**
     * Get the message name (e.g. the type).
     *
     * @return string
     */
    public function getName()
    {
        return get_class($this);
    }
}
