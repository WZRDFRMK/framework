<?php

namespace WZRD\Mail;

use WZRD\Contracts\Mail\Mailer;
use WZRD\Contracts\Mail\Message as MessageContract;

class Handler implements Mailer
{
    /**
     * Mailers.
     *
     * @var WZRD\Contracts\Mail\Mailer[]
     */
    protected $mailers;

    /**
     * Construct with mailers instances.
     *
     * @param WZRD\Contracts\Mail\Mailer[] $mailers
     */
    public function __construct(array $mailers)
    {
        $this->mailers = $mailers;
    }

    /**
	 * Send a mail
	 *
	 * @param  WZRD\Contracts\Mail\Message  $message
	 * @param  array  $options
	 */
	public function send(MessageContract $message, $options = array())
    {
        foreach($this->mailers as $mailer) {
            if($mailer instanceof Mailer) {
                $mailer->send($message, $options);
            }
        }
    }
}
