<?php

namespace Wzrd\Mail;

use Wzrd\Contracts\Mail\Mailer;
use Wzrd\Contracts\Mail\Message as MessageContract;

class Handler implements Mailer
{
    /**
     * Mailers.
     *
     * @var Wzrd\Contracts\Mail\Mailer[]
     */
    protected $mailers;

    /**
     * Construct with mailers instances.
     *
     * @param Wzrd\Contracts\Mail\Mailer[] $mailers
     */
    public function __construct(array $mailers)
    {
        $this->mailers = $mailers;
    }

    /**
	 * Send a mail
	 *
	 * @param  Wzrd\Contracts\Mail\Message  $message
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
