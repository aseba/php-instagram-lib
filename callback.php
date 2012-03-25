<?php

if(isset($_REQUEST['hub_challenge'])) echo $_GET['hub_challenge'];

$file = file_get_contents('/tmp/updates.instagram');
$file .= json_encode($_REQUEST);
file_put_contents('/tmp/updates.instagram', $file);
echo $file;

?>