<?php

namespace WZRD\Messaging;

use ArrayIterator;
use WZRD\Contracts\Messaging\Message as MessageContract;
use WZRD\Contracts\Messaging\Stream as StreamContract;

class Stream implements StreamContract
{
    /**
     * Messages.
     *
     * @var WZRD\Messaging\Message[]
     */
    protected $messages;

    /**
     * Initialize messages stream.
     *
     * @param WZRD\Messaging\Message[] $messages
     */
    public function __construct(array $messages)
    {
        $this->messages = [];

        foreach ($messages as $message) {
            $this->push($message);
        }
    }

    /**
     * Iterator.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->messages);
    }

    /**
     * Push message into the stream.
     *
     * @param WZRD\Contracts\Messaging\Message $message
     *
     * @return self
     */
    public function push(MessageContract $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Shift a message off the beginning of the stream.
     *
     * @return WZRD\Contracts\Messaging\Message
     */
    public function shift()
    {
        return array_shift($this->messages);
    }

    /**
     * Flush stream.
     *
     * @return self
     */
    public function flush()
    {
        $this->messages = [];

        return $this;
    }
}
