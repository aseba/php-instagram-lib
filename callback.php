<?php

if(isset($_GET['hub_challenge'])) echo $_GET['hub_challenge'];
else{
	$file = file_get_contents('/tmp/updates.instagram');
	$fulldata = $file . "\n\n" . $posted_data;
	$igdata = file_get_contents("php://input");
	file_put_contents('/tmp/updates.instagram', $fulldata);
}

?>