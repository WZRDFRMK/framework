<?php

namespace Wzrd\Framework\Mail;

use Swift_Mailer;
use Swift_Message;
use Wzrd\Contracts\Mail\Mailer;

class SwiftMailer implements Mailer
{
    /**
     * Swift.
     *
     * @var Swift_Mailer
     */
    private $swift;

    /**
     * Création d'une instance SwiftMailer
     *
     * @param Swift_Mailer $swift
     */
    public function __construct(Swift_Mailer $swift)
    {
        $this->swift = $swift;
    }

    /**
	 * Send a mail
	 *
	 * @param  array  $data
	 */
	public function send(array $data)
    {
        $message = Swift_Message::newInstance();

        if(!empty($data['subject'])) {
            $message->setSubject($data['subject']);
        }

        if(!empty($data['from'])) {
            $message->setFrom($data['from']);
        }

        if(!empty($data['to'])) {
            $message->setTo($data['to']);
        }

        if(!empty($data['bcc'])) {
            $message->setBcc($data['bcc']);
        }

        if(!empty($data['body'])) {
            $message->setBody($data['body']);
        }

        $this->swift->send($message);
    }
}
