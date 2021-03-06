<?php

namespace WZRD\Test\Mail;

use Mockery;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;

class HandlerTest extends PHPUnit_Framework_TestCase
{
    public function test_send()
    {
        // Setup mailers
        $mailer1 = $mailer2 = Mockery::mock('WZRD\Contracts\Mail\Mailer')->makePartial();
        $mailers = [$mailer1, $mailer2, new \StdClass()];

        // Configure handler
        $handler = new Framework\Mail\Handler($mailers);

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
        $message->attach('filename.jpg', ['filename' => 'cool.jpg', 'content-type' => 'image/jpg']);
        $message->inline('filename2.jpg', ['filename' => 'yeah.jpg']);

        // Prepare test
        $mailer1->shouldReceive('send')->with($message, [])->once();
        $mailer2->shouldReceive('send')->with($message, [])->once();

        // Send !
        $handler->send($message);
    }
}
