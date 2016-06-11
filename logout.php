<?php
	session_start();
	
	unset($_SESSION['login']);
	session_destroy();
	
	session_start();
	$_SESSION = array();
	
	require_once('inc/functions.php');
	add_success_msg("Successfully Logged out");
	lets_go('index.php');
	
?>