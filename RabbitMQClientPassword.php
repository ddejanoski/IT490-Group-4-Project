<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("passwordRMQ.ini","testServer");

if (isset($_GET['changepwd'])) {
	$request = array();
	$request['type'] = "changepassword";
	$request['email'] = $_SESSION["email"];
	$request['password'] = $_GET["newpassword"];
	$request['message']  = $msg;
	
	$response = $client->send_request($request);	

	if ($response==0){
		header('location: changepassword.php');
		echo '<script>alert("Password change unsuccessful, try again")</script>';
	}
	else{ 
		header('location: profile.php');
		echo '<script>alert("Password change successful, try again")</script>';
	}
} 

?>