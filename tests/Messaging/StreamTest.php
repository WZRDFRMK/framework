<?php

namespace WZRD\Test\Messaging;

use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class StreamTest extends PHPUnit_Framework_TestCase
{
    public function test_stream()
    {
        // Build messages
        $messages = [
            new BadMessage('aa', 'bb'),
            new CustomMessage('aa', 'bb'),
            new CustomMessage('aa', 'bb'),
        ];

        // Init the stream
        $stream = new Framework\Messaging\Stream($messages);

        // Test size
        $this->assertCount(3, $stream);

        // Add message and test it
        $stream->push(new CustomMessage('aa', 'bb'));
        $this->assertCount(4, $stream);

        // Shift the stream
        $this->assertInstanceOf('WZRD\Test\Messaging\BadMessage', $stream->shift());
        $this->assertCount(3, $stream);

        // Flush the stream
        $stream->flush();
        $this->assertCount(0, $stream);
    }
}
