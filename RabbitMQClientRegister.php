<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
//require_once('receiveRegister.php');

$client = new rabbitMQClient("registerRMQ.ini","testServer");
//echo "ppdClient BEGIN".PHP_EOL;

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

if(isset($_GET['register'])){
	$request = array();
	$request['type'] = "register";
	$request['email'] = $_GET["email"];
	$request['username'] = $_GET["username"];
	$request['password'] = $_GET["password"];

	$request['message'] = $msg;

	$response = $client->send_request($request);

	print_r($response);
	
	if ($response==0){
		header('location: register.php');
	}
	else{ 
		$_SESSION['email'] = $request['email'];
      	$_SESSION['success'] = "You are now registered";
		$_SESSION['json'] = json_decode($response);
		header('location: game.php');	
	}
}

?>