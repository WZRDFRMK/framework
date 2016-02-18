<?php

namespace WZRD\Test\Messaging;

use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class TacticianBusTest extends PHPUnit_Framework_TestCase
{
    public function test_bus()
    {
        // Init the bus
        $bus = new Framework\Messaging\TacticianBus();

        // Init handlers
        $handler     = new CustomHandler();
        $bad_handler = new AnotherHandler();

        // Subscribing the handlers
        $bus->subscribe($handler);
        $bus->subscribe($bad_handler);

        // Build the message
        $message = new CustomMessage('aa', 'bb');

        // Dispatch the message
        $this->assertEquals('ok', $bus->dispatch($message));
    }
}
