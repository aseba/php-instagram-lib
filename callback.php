<?php

require_once 'phpirt.php';

class MyProcessor extends SubscriptionProcessor {
	// Redefine this function
	// public static function process($data){}
}

if(isset($_GET['hub_challenge'])) echo $_GET['hub_challenge'];
else{
	$igdata = json_decode(file_get_contents("php://input"));
	MyProcessor::process($igdata);
}

?>