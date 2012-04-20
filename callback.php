<?php

require_once 'phpirt.php';

class MyProcessor extends SubscriptionProcessor {
	const client_secret = 'YOUR API SECRET';
	// Redefine this function
	public static function process($data){
		$file = file_get_contents('/tmp/updates.instagram');
		$fulldata = $file . "\n\n" . json_encode($data);
		file_put_contents('/tmp/updates.instagram', $fulldata);
	}
}

if(isset($_GET['hub_challenge'])) echo $_GET['hub_challenge'];
else{
	if(isset($_SERVER['HTTP_X_HUB_SIGNATURE'])){
		$igdata = file_get_contents("php://input");
		if(hash_hmac('sha1', $igdata, MyProcessor::client_secret) == $_SERVER['HTTP_X_HUB_SIGNATURE'])
			MyProcessor::process(json_decode($igdata));
	}
}

?>
