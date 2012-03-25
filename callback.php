<?php

if(isset($_GET)){
	if(isset($_GET['hub_challenge'])) echo $_GET['hub_challenge'];
}

if(isset($_POST)){
	$file = file_get_contents('updates.instagram');
	$file .= json_encode($_POST);
	file_put_contents('updates.instagram', $file);
}

?>