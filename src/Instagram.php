<?php

namespace Instagram;

use \GuzzleHttp\Client;

class Instagram {
	private $settings = [];
	private $last_url = '';
	private $debug = false;
	private $guzzle;
	private $access_token;

	public function __construct($client_id, $client_secret, $callback_url=null) {
		$this->settings = array(
			'client_id' => $client_id,
			'client_secret' => $client_secret
		);
		if (!is_null($callback_url)) {
			$this->settings['callback_url'] = $callback_url;
		}

		$this->guzzle = new \GuzzleHttp\Client(
			['base_uri' => "https://api.instagram.com/v1/"]
		);
	}

	private function generate_signature($endpoint, $params) {
	  $sig = $endpoint;
	  ksort($params);
	  foreach ($params as $key => $val) {
	    $sig .= "|$key=$val";
	  }
	  return hash_hmac('sha256', $sig, $this->settings['client_secret'], false);
	}

	public function generic($endpoint='', $params=[]) {
		$response = $this->guzzle->get($endpoint, [
			"query" => [
				'access_token' => $this->access_token,
			]
		]);
		return(json_decode($response->getBody(), true));
	}

	public function getLogin($response_type='code', array $scopes=[]) {
		$url = "https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=%s";
		$params = [
			$this->settings['client_id'],
			$this->settings['callback_url'],
			$response_type
		];

		if(!is_null($scopes)) {
			$url .= "&scope=%s";
			$params[] = implode("+", $scopes);
		}

		return vsprintf($url, $params);
	}

	public function set_access_token($access_token) {
		$this->access_token = $access_token;
	}

	public function debug($debug=true){
		$this->debug = (Bool) $debug;
	}
}
