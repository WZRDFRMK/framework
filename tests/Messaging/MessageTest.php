<?php

namespace WZRD\Test\Messaging;

use DateTime;
use PHPUnit_Framework_TestCase;

class MessageTest extends PHPUnit_Framework_TestCase
{
    public function test_message_get_set()
    {
        // Compose the message
        $message = new CustomMessage('aa', 'bb');

        // Tests
        $this->assertEquals(new DateTime(), $message->getRecordedDate());
        $this->assertInternalType('string', $message->getId());
        $this->assertEquals('WZRD\Test\Messaging\CustomMessage', $message->getName());
        $this->assertEquals(['payload1' => 'aa', 'payload2' => 'bb'], $message->getPayload());
    }
}
