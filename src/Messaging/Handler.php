<?php

namespace WZRD\Messaging;

use BadMethodCallException;
use WZRD\Contracts\Messaging\Handler as HandlerContract;
use WZRD\Contracts\Messaging\Message as MessageContract;

abstract class Handler implements HandlerContract
{
    /**
     * Handle the message.
     *
     * @param WZRD\Contracts\Messaging\Message $message
     *
     * @return mixed
     */
    final public function handle(MessageContract $message)
    {
        if (!method_exists($this, 'process')) {
            throw new BadMethodCallException('process() function not defined');
        }

        return $this->process($message);
    }
}
