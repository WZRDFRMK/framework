<?php

namespace Wzrd\Framework\Push;

use Wzrd\Contracts\Push\Pusher;
use ZendService\Google\Gcm\Client;
use ZendService\Google\Gcm\Message;

class GcmPusher implements PusherInterface
{
	/**
	* GCM.
	*
	* @var ZendService\Google\Gcm\Client
	*/
	private $gcm_client;

	/**
	* Création d'une instance ZendService\Google\Gcm\Client
	*
	* @param ZendService\Google\Gcm\Client $gcm_client
	*/
	public function __construct(Client $gcm_client)
	{
		$this->gcm_client = $gcm_client;

		$new_client = new \Zend\Http\Client(null, array(
			'adapter' => 'Zend\Http\Client\Adapter\Socket',
			'sslverifypeer' => false
		));

		$this->gcm_client->setHttpClient($new_client);

	}

    /**
	 * Push data
	 *
	 * @param  array  $data
	 */
	public function push(array $data)
	{
		$message = new Message();

		if(!empty($data['to'])) {
			$message->setRegistrationIds(is_array($data['to']) ? $data['to'] : array($data['to']));
		}

		if(!empty($data['data'])) {
			$message->setData(is_array($data['data']) ? $data['data'] : array($data['data']));
		}

		if(!empty($data['collapse_key'])) {
			$message->setCollapseKey($data['collapse_key']);
		}

		if(!empty($data['restricted_package_name'])) {
			$message->setRestrictedPackageName($data['restricted_package_name']);
		}

		if(!empty($data['delay_while_idle'])) {
			$message->setDelayWhileIdle(true);
		}

		if(!empty($data['ttl'])) {
			$message->setTimeToLive($data['ttl']);
		}

		if(!empty($data['dry_run'])) {
			$message->setDryRun(true);
		}

		try {
			$response = $this->gcm_client->send($message);
			return true;
		} catch (RuntimeException $e) {
			return false;
		}
	}
}
