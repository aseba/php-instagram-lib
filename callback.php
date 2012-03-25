<?php

if(isset($_REQUEST['hub_challenge'])) echo $_GET['hub_challenge'];
else{
	$file = file_get_contents('/tmp/updates.instagram');
	$file .= json_encode($_REQUEST['data']);
	file_put_contents('/tmp/updates.instagram', $file);
	echo $file;
}

?>