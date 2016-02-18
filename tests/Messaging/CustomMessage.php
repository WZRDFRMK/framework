<?php

namespace WZRD\Test\Messaging;

use WZRD\Messaging\Message;

class CustomMessage extends Message
{
    public function __construct($payload1, $payload2)
    {
        $this->payload1 = $payload1;
        $this->payload2 = $payload2;
    }
}
