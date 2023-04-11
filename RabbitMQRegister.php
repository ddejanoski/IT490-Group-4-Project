<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = AMQPStreamConnection::create_connection([
    ['host' => '172.25.214.177', 'port' => 5672, 'user' => 'admin', 'password' => 'admin', 'vhost' => 'project490'],
    ['host' => '172.25.68.221', 'port' => 5672, 'user' => 'admin', 'password' => 'admin', 'vhost' => 'project490'],
    ['host' => '172.25.153.116', 'port' => 5672, 'user' => 'admin', 'password' => 'admin', 'vhost' => 'project490']
],
[]);
	
$channel = $connection->channel();

$channel->exchange_declare('registerExchange3', 'quorum', false, false, false);

$channel->queue_declare('registerQ2', false, false, false, false);




if(isset($_GET['register'])){
	$request = array();
	$request['type'] = "register";
	$request['email'] = $_GET["email"];
	$request['username'] = $_GET["username"];
	$request['password'] = $_GET["password"];

	//$request['message'] = $msg;

	//$response = $client->send_request($request);
    $msg = new AMQPMessage($request, array('reply_to' => $register_reply));

    $channel->basic_publish($msg, 'register');

	$callback = function ($msg){
		if ($msg==0){
			header('location: register.php');
		}
		else{ 
			$_SESSION['email'] = $msg['email'];
			$_SESSION['success'] = "You are now registered";
			$_SESSION['json'] = json_decode($msg);
			header('location: game.php');	
		}

	};

	while ($channel->is_open()){
		$channel->wait();
	}

	$channel->close();
	$connection->close();
}

?>