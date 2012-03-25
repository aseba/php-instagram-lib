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
		$curl->debug = true;
		$url = $this->base_url . '/subscriptions/';
		print_r(json_decode($curl->delete($url, $params), true));
		$this->listSubscriptions();
	}
}

$irt = new InstagramRealTime('699495b3bfaf4632bdc5096e7544ff23', '68af47b6e9174f5dbb94ef913fdc42b3', 'http://public.olapic.com/~aseba/PHPIRT/callback.php');
$irt->addSubscription('tag', 'media', 'nyc');
$irt->addSubscription('tag', 'media', 'hq');
$irt->addSubscription('tag', 'media', 'catan');
// $irt->listSubscriptions();
// $irt->deleteSubscription('all');

?>