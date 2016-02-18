<?php

namespace WZRD\Test\Messaging;

use WZRD\Messaging\Message;

class BadMessage extends Message
{
    public function __construct($payload1, $payload2)
    {
        $this->payload1 = $payload1;
        $this->payload2 = $payload2;
    }
}
