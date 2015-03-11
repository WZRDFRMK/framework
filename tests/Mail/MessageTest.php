<?php

namespace Wzrd\Framework\Test\Mail;

use Mockery;
use PHPUnit_Framework_TestCase;
use Wzrd\Framework as Framework;

class MessageTest extends PHPUnit_Framework_TestCase
{
    public function test_message_get_set()
    {
        // Compose the message
        $message = new Framework\Mail\Message();

        $message->addFrom('from@sdis62.fr');
        $message->addFrom('from@domain.fr', 'From');

        $message->addTo('to@sdis62.fr');
        $message->addTo('to@domain.fr', 'To');

        $message->addCc('cc@sdis62.fr');
        $message->addCc('cc@domain.fr', 'Cc');

        $message->addBcc('bcc@sdis62.fr');
        $message->addBcc('bcc@domain.fr', 'Bcc');

        $message->setSubject('Subject');

        $message->setText('Text');

        $message->setHtml('<p>HTML</p>');

        $message->attach('filename.jpg', array('filename' => 'cool.jpg'));

        $message->inline('filename2.jpg', array('filename' => 'yeah.jpg'));

        // Tests
        $this->assertEquals(['from@sdis62.fr' => null, 'from@domain.fr' => 'From'], $message->getFrom());
        $this->assertEquals(['to@sdis62.fr' => null, 'to@domain.fr' => 'To'], $message->getTo());
        $this->assertEquals(['cc@sdis62.fr' => null, 'cc@domain.fr' => 'Cc'], $message->getCc());
        $this->assertEquals(['bcc@sdis62.fr' => null, 'bcc@domain.fr' => 'Bcc'], $message->getBcc());
        $this->assertEquals([['filename.jpg', ['filename' => 'cool.jpg']]], $message->getAttachments());
        $this->assertEquals([['filename2.jpg', ['filename' => 'yeah.jpg']]], $message->getInlines());
        $this->assertEquals('Subject', $message->getSubject());
        $this->assertEquals('Text', $message->getText());
        $this->assertEquals('<p>HTML</p>', $message->getHtml());
    }
}
