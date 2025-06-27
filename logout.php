<?php

// Start Session

session_start();

error_reporting(0);

$url = $_GET['url'];

// Session Destroy

if(session_destroy()){
	echo '<meta http-equiv=refresh content="0; url=login.php?url='.$url.'">';
}

?>