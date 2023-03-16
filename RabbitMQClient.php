<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
//echo "ppdClient BEGIN".PHP_EOL;

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

if (isset($_POST['login'])) {
	$request = array();
	$request['type'] = "Login";
	$request['email'] = $_POST["email"];
	$request['password'] = $_POST["password"];
	$request['message']  = $msg;
	
	$response = $client->send_request($request);	
	print_r($response);

	if (!$response){
		array_push($errors, "Incorrect email or password");	
	}
	if ($response){  	
		$_SESSION['username'] = $request['username'];
      	$_SESSION['success'] = "Login Succesful!";  
		$_SESSION['json'] = json_decode($response);
		header('location: index.php');
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
	header('location: index.php');

	//print_r($response);
	
	if ($response==1){
		//echo "<strong>Registration Succesful</strong>";
		$_SESSION['username'] = $request['username'];
		//$_SESSION['firstname'] = $request['firstname'];
      	$_SESSION['success'] = "You are now logged in";
		$_SESSION['json'] = json_decode($response);
		header('location: index.php');	
	}
	else{ 
		array_push($errors, "User already exists"); 
	}
}

?>