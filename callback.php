<?php

if(isset($_GET['hub_challenge'])) echo $_GET['hub_challenge'];
if(isset($_POST)){
	$file = file_get_contents('/tmp/updates.instagram');
	$data = print_r($_REQUEST);
	$fulldata = $file . "\n\n" . $data;
	file_put_contents('/tmp/updates.instagram', $fulldata);
	echo $file;
}

?>