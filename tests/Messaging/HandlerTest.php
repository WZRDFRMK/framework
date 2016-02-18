<?php

namespace WZRD\Test\Messaging;

use BadMethodCallException;
use PHPUnit_Framework_TestCase;

class HandlerTest extends PHPUnit_Framework_TestCase
{
    public function test_handler()
    {
        // Init the handler
        $handler = new CustomHandler();

        // Compose the message
        $message = new CustomMessage('aa', 'bb');

        // Tests
        $this->assertEquals('ok', $handler->handle($message));
    }

    public function test_bad_handler()
    {
        // Init the handler
        $bad_handler = new BadHandler();

        // Compose the message
        $message = new CustomMessage('aa', 'bb');

        // Tests
        $this->expectException(BadMethodCallException::class);
        $bad_handler->handle($message);
    }
}
