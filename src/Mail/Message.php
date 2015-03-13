<?php

namespace Wzrd\Mail;

use Wzrd\Contracts\Mail\Message as MessageContract;

class Message implements MessageContract
{
    /**
     * From addresses
     *
     * @var array
     */
    protected $from;

    /**
     * Recipients addresses
     *
     * @var array
     */
    protected $to;

    /**
     * CC addresses
     *
     * @var array
     */
    protected $cc;

    /**
     * BCC addresses
     *
     * @var array
     */
    protected $bcc;

    /**
     * Subject
     *
     * @var string
     */
    protected $subject;

    /**
     * Text
     *
     * @var string
     */
    protected $text;

    /**
     * HTML
     *
     * @var string
     */
    protected $html;

    /**
     * Attachments
     *
     * @var array
     */
    protected $attach;

    /**
     * Attachments with inline disposition
     *
     * @var array
     */
    protected $inline;

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->text = $this->html = $this->subject = '';
        $this->from = $this->to = $this->cc = $this->bcc = $this->attach = $this->inline = array();
    }

    /**
	 * Add a "from" address to the message.
	 *
	 * @param  string  $address
	 * @param  string  $name
	 * @return self
	 */
	public function addFrom($address, $name = null)
    {
        $this->from[$address] = $name;

        return $this;
    }

    /**
	 * Get "from" addresses
	 *
	 * @return array
	 */
	public function getFrom()
    {
        return $this->from;
    }

	/**
	 * Add a recipient to the message.
	 *
	 * @param  string  $address
	 * @param  string  $name
	 * @return self
	 */
	public function addTo($address, $name = null)
    {
        $this->to[$address] = $name;

        return $this;
    }

    /**
	 * Get recipients addresses
	 *
	 * @return array
	 */
	public function getTo()
    {
        return $this->to;
    }

	/**
	 * Add a carbon copy to the message.
	 *
	 * @param  string  $address
	 * @param  string  $name
	 * @return self
	 */
	public function addCc($address, $name = null)
    {
        $this->cc[$address] = $name;

        return $this;
    }

    /**
     * Get carbon copies addresses
     *
     * @return array
     */
    public function getCc()
    {
        return $this->cc;
    }

	/**
	 * Add a blind carbon copy to the message.
	 *
	 * @param  string  $address
	 * @param  string  $name
	 * @return self
	 */
	public function addBcc($address, $name = null)
    {
        $this->bcc[$address] = $name;

        return $this;
    }

    /**
	 * Get blind carbon copies addresses
	 *
	 * @return array
	 */
	public function getBcc()
    {
        return $this->bcc;
    }

    /**
    * Set the subject of the message.
    *
    * @param  string  $subject
    * @return self
    */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
    * Get subject.
    *
    * @return string
    */
    public function getSubject()
    {
        return $this->subject;
    }

	/**
	 * Set the text of the message.
	 *
	 * @param  string  $text
	 * @return $this
	 */
	public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
	 * Get text
	 *
	 * @return string
	 */
	public function getText()
    {
        return $this->text;
    }

	/**
	 * Set the html of the message.
	 *
	 * @param  string  $html
	 * @return $this
	 */
	public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
	 * Get HTML
	 *
	 * @return string
	 */
	public function getHtml()
    {
        return $this->html;
    }

	/**
	 * Attach a file to the message.
	 *
	 * @param  string  $file
	 * @param  array   $options
	 * @return $this
	 */
	public function attach($file, array $options = array())
    {
        $this->attach[] = array($file, $options);

        return $this;
    }

    /**
	 * Get attachments
	 *
	 * @return array
	 */
	public function getAttachments()
    {
        return $this->attach;
    }

	/**
	 * Attach a file to the message with inline disposition.
	 *
	 * @param  string  $file
	 * @param  array   $options
	 * @return $this
	 */
	public function inline($file, array $options = array())
    {
        $this->inline[] = array($file, $options);

        return $this;
    }

    /**
	 * Get inlines attachments
	 *
	 * @return array
	 */
	public function getInlines()
    {
        return $this->inline;
    }
}
