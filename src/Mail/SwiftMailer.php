<?php

namespace WZRD\Mail;

use Swift_Mailer;
use Swift_Message;
use Swift_Attachment;
use Swift_EmbeddedFile;
use WZRD\Contracts\Mail\Mailer;
use WZRD\Contracts\Mail\Message as MessageContract;

class SwiftMailer implements Mailer
{
    /**
     * Swift.
     *
     * @var Swift_Mailer
     */
    private $swift;

    /**
     * Construct with SwiftMailer instance
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
	 * @param  WZRD\Contracts\Mail\Message  $message
	 * @param  array  $options
	 */
	public function send(MessageContract $message, $options = array())
    {
        // Initialisation d'un nouveau message
        $swift_message = Swift_Message::newInstance();

        // Compose
        $swift_message->setFrom($message->getFrom());
        $swift_message->setTo($message->getTo());
        $swift_message->setCc($message->getCc());
        $swift_message->setBcc($message->getBcc());
        $swift_message->setSubject($message->getSubject());
        $swift_message->addPart($message->getText(), 'text/plain');
        $swift_message->addPart($message->getHtml(), 'text/html');

        // Attachments
        foreach($message->getAttachments() as $attachment) {
            list($file, $options) = $attachment;

            $content_type = empty($options['content-type']) ? null : $options['content-type'];

            $attachment = Swift_Attachment::fromPath($file, $content_type);

            if(!empty($options['filename'])) {
                $attachment->setFilename($options['filename']);
            }

            $swift_message->attach($attachment);
        }

        // Inline attachments
        foreach($message->getInlines() as $inline) {
            list($file, $options) = $inline;

            $content_type = empty($options['content-type']) ? null : $options['content-type'];

            $attachment = Swift_EmbeddedFile::fromPath($file, $content_type);

            if(!empty($options['filename'])) {
                $attachment->setFilename($options['filename']);
            }

            $swift_message->embed($attachment);
        }

        // Send !
        $this->swift->send($swift_message);
    }
}
