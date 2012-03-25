<?php

require_once 'phpirt.php';

class MyProcessor extends SubscriptionProcessor {
	// Redefine this function
	public static function process($data){
		$file = file_get_contents('/tmp/updates.instagram');
		$fulldata = $file . "\n\n" . json_encode($data);
		file_put_contents('/tmp/updates.instagram', $fulldata);
	}
}

if(isset($_GET['hub_challenge'])) echo $_GET['hub_challenge'];
else{
	$igdata = json_decode(file_get_contents("php://input"));
	$igdata = array_merge($igdata, $_SERVER);
	MyProcessor::process($igdata);
}

?>