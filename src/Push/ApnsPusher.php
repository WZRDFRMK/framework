<?php

namespace Wzrd\Framework\Push;

use Wzrd\Contracts\Push\Pusher;
use ZendService\Apple\Apns\Client\Message as Client;
use ZendService\Apple\Apns\Client\Feedback as ClientFeedback;
use ZendService\Apple\Apns\Message;
use ZendService\Apple\Apns\Message\Alert;
use ZendService\Apple\Apns\Response\Feedback;
use ZendService\Apple\Apns\Response\Message as Response;
use ZendService\Apple\Apns\Exception\RuntimeException;

class ApnsPusher implements PusherInterface
{
	/**
	* Apns.
	*
	* @var ZendService\Apple\Apns\Client\Message
	*/
	private $apns_client;

	/**
	* Création d'une instance ZendService\Apple\Apns\Client\Message
	*
	* @param ZendService\Apple\Apns\Client\Message $apns_client
	*/
	public function __construct(Client $apns_client)
	{
		$this->apns_client = $apns_client;
	}

    /**
	 * Push data
	 *
	 * @param  array  $data
	 */
	public function push(array $data)
	{
		$message = new Message();

		if(!empty($data['id'])) {
			$message->setId($data['id']);
		}

		if(!empty($data['token'])) {
			$message->setToken($data['token']);
		}

		if(!empty($data['badge'])) {
			$message->setBadge($data['badge']);
		}

		if(!empty($data['sound'])) {
			$message->setSound($data['sound']);
		}

		if(!empty($data['alert'])) {

			$alert = new Alert();

			if(!empty($data['alert']['body'])) {
				$alert->setBody($data['alert']['body']);
			}

			if(!empty($data['alert']['action_loc_key'])) {
				$alert->setActionLocKey($data['alert']['action_loc_key']);
			}

			$message->setAlert($alert);
		}

		try {
			$response = $this->apns_client->send($message);
			$client->close();
			return true;
		} catch (RuntimeException $e) {
			return false;
		}
	}

	/**
	 * Get feedback.
	 *
	 * @return array
	 */
	public function feedback(array $data)
	{
		// TODO
		$client = new ClientFeedback();
		$client->open(Client::SANDBOX_URI, '/path/to/push-certificate.pem', 'optionalPassPhrase');
		$responses = $client->feedback();
		$client->close();

		return $responses;
	}
}
