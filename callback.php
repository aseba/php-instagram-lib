<?php

if(isset($_GET)){
	if(isset($_GET['hub_challenge'])) echo $_GET['hub_challenge'];
}

?>