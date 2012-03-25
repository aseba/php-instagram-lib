<?php

require 'curl/curl.php';

class InstagramRealTime {
	private $settings = array();
	private $base_url = 'https://api.instagram.com/v1';

	public function InstagramRealTime($client_id, $client_secret, $callback_url){
		$this->settings = array(
			'client_id' => $client_id,
			'client_secret' => $client_secret,
			'callback_url' => $callback_url
		);
	}

	public function addSubscription($object, $aspect, $object_id=null){
		$params = array_merge($this->settings, array(
			'object' => $object,
			'aspect' => $aspect
		));
		if(!is_null($object_id)) $params['object_id'] = $object_id;
		$curl = new Curl;
		$url = $this->base_url . '/subscriptions/';
		echo $curl->post($url, $params);
	}

	public function listSubscriptions(){
		$params = $this->settings;
		$curl = new Curl;
		$url = $this->base_url . '/subscriptions/';
		print_r(json_decode($curl->get($url, $params), true));
	}

	public function deleteSubscription($object=null, $id=null){
		if(is_null($object) and is_null($id)) throw new Exception("You must set and object type or and object id. If you want to delete all set object as 'all'");
		elseif(!is_null($object) and is_null($id)) {
			$params = array_merge($this->settings, array(
				'object' => $object
			));
		}
		elseif(is_null($object) and !is_null($id)) {
			$params = array_merge($this->settings, array(
				'id' => $id
			));
		}
		else throw new Exception("You must set and object type or and object id, not both"); 
		$curl = new Curl;
		// This is done because it seems instagram does not accept params correctly (or something). We got to send them in the url
		$params = http_build_query($params, '', '&');
		$url = $this->base_url . '/subscriptions?' . $params;
		print_r(json_decode($curl->delete($url, $params), true));
	}
}

class SubscriptionProcessor{
	public static function process($data){
		$file = file_get_contents('/tmp/updates.instagram');
		$fulldata = $file . "\n\n" . json_encode($data);
		file_put_contents('/tmp/updates.instagram', $fulldata);
	}
}

?>
