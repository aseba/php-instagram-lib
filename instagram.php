<?php

require 'HttpClient.class.php';

class InstagramRealTime{
	$settings = array();

	public function InstagramRealTime($client_id, $client_secret, $callback_url){
		$this->settings(
			'client_id' => $client_id,
			'client_secret' => $client_secret,
			'callback_url' => $callback_url
		);
	}

	public function addSubscription(){
		$params = array_merge($this->settings, array(
			'object' => 'user',
			'aspect' => 'media'
		));

		HttpClient::quickPost('https://api.instagram.com/v1/subscriptions/',);
	}
}

InstagramRealTime('699495b3bfaf4632bdc5096e7544ff23', '68af47b6e9174f5dbb94ef913fdc42b3', '')->run();

?>