<?php

if(isset($_GET)){
	if(isset($_GET['hub.challenge'])) echo $_GET['hub.challenge'];
}

?>