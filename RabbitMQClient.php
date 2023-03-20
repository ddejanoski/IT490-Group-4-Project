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

if (isset($_GET['login'])) {
	$request = array();
	$request['type'] = "login";
	$request['email'] = $_GET["email"];
	$request['password'] = $_GET["password"];
	$request['message']  = $msg;
	
	$response = $client->send_request($request);	

	print_r($response);

	/*
	if (!$response){
		array_push($errors, "Incorrect email or password");	
	}
	if ($response){  	
		$_SESSION['username'] = $request['username'];
      	$_SESSION['success'] = "Login Succesful!";  
		$_SESSION['json'] = json_decode($response);
		header('location: game.php');
	} */
	if ($response==1){
		//echo "<strong>Registration Succesful</strong>";
		//$_SESSION['username'] = $request['username'];
      	$_SESSION['success'] = "You are now logged in";
		$_SESSION['logged_in'] = true;
		$_SESSION['json'] = json_decode($response);
		header('location: game.php');	
	}
	else{ 
		header('location: login.php');
		//array_push($errors, "Credentials invalid"); 
		
	}
} 

//REGISTRATION
if(isset($_GET['register'])){
	$request = array();
	$request['type'] = "register";
	$request['email'] = $_GET["email"];
	$request['username'] = $_GET["username"];
	$request['password'] = $_GET["password"];

	$request['message'] = $msg;

	$response = $client->send_request($request);
	
	if ($response==1){
		$_SESSION['username'] = $request['username'];
      	$_SESSION['success'] = "You are now logged in";
		//$_SESSION['json'] = json_decode($response);
		header('location: game.php');	
	}
	else{ 
		//($errors, "User already exists"); 
		header('location: register.php');
	}
}

?>