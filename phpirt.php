<?php

require 'curl/curl.php';

class InstagramRealTime {
	private $settings = array();
	private $base_url = 'https://api.instagram.com/v1';
	private $signature;

	public function InstagramRealTime($client_id, $client_secret, $callback_url=null){
		$this->settings = array(
			'client_id' => $client_id,
			'client_secret' => $client_secret
		);
		if(!is_null($callback_url)){
			$this->settings['callback_url'] = $callback_url;
		}
	}

	public function addSignature($ip) {
		if (empty($this->settings['client_secret'])) {
			throw new Exception('Can not sign the request without OAuth Client Secret');
		}
		$this->signature = $ip .'|'. hash_hmac('sha256', $ip, $this->settings['client_secret'], false);
	}

	public function addSubscription($object, $aspect, $object_id=null, $extra=array()){
		$params = array_merge($this->settings, array(
			'object' => $object,
			'aspect' => $aspect
		));
		if(!is_null($object_id)) $params['object_id'] = $object_id;
		foreach($extra as $extraKey=>$extraValue){
			$params[$extraKey] = $extraValue;
		}
		return $this->generic("/subscriptions/", $params);
	}

	public function listSubscriptions(){
		return $this->generic("/subscriptions/");
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
		return(json_decode($curl->delete($url, $params), true));
	}

	public function generic($endpoint='', $params=array()){
		$curl = $this->getCurl();
		$params = array_merge( $this->settings, $params );
		$url = $this->base_url . $endpoint;
		return(json_decode($curl->get($url, $params), true));
	}

	public function genericPost($endpoint='', $params=array()){
		$curl = $this->getCurl();
		$params = array_merge( $this->settings, $params );
		$url = $this->base_url . $endpoint;
		return(json_decode($curl->post($url, $params), true));
	}

	protected function getCurl() {
		$curl = new Curl;
		if (!is_null($this->signature)) {
			$curl->headers['X-Insta-Forwarded-For'] = $this->signature;
		}
		return $curl;
	}
}

class SubscriptionProcessor{
	public static function process($data){}
}
