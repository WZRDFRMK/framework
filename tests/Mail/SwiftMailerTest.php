<?php

namespace Wzrd\Test\Mail;

use Mockery;
use Swift_Mailer;
use Swift_Message;
use Swift_Attachment;
use Swift_EmbeddedFile;
use PHPUnit_Framework_TestCase;
use Wzrd as Framework;

class SwiftMailerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->swift = Mockery::mock('Swift_Mailer')->makePartial();
        $this->mailer = new Framework\Mail\SwiftMailer($this->swift);
    }

    public function test_send()
    {
        // Prepare message
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
        $message->attach('filename.jpg', array('filename' => 'cool.jpg', 'content-type' => 'image/jpg'));
        $message->inline('filename2.jpg', array('filename' => 'yeah.jpg'));

        // Prepare test
        $this->swift->shouldReceive('send')->once();

        // Send !
        $this->mailer->send($message);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
