<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
//require_once('receiveRegister.php');

$client = new rabbitMQClient("loginRMQ.ini","testServer");
//echo "ppdClient BEGIN".PHP_EOL;

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

if (isset($_GET['login'])) {
	$request = array();
	$request['type'] = "login";
	$request['email'] = $_GET["email"];
	$request['password'] = $_GET["password"];
	$request['message']  = $msg;
	
	$response = $client->send_request($request);	

	if ($response==0){
		header('location: login.php');
		echo '<script>alert("Login unsuccessful, try again")</script>';
	}
	else{ 
		$_SESSION['success'] = "You are now logged in";
		$_SESSION['email'] = $request['email'];
		$_SESSION['logged_in'] = true;
		$_SESSION['json'] = json_decode($response);
		header('location: game.php');
	}
} 

?>