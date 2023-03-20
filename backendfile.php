<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function queryDatabase($request)
{
	echo "Connecting to Database\n";
	$client = new rabbitMQClient("registerToDB.ini", "testserver");
	echo "initializing RMQ client\n";
	$validate = $request;
	echo "Sending retrieved message to db server...\n";
	$response = $client->send_request($validate);
	echo "Sending response back to client...\n" . var_dump($response);
	return $response;
}

function registerUser($request)
{
    // Verify username
    if (!isset($request['username'])) {
        return "ERROR: No username provided";
    }

    $username = trim($request['username']);

    if (strlen($username) < 4 || strlen($username) > 20) {
        return "ERROR: Username must be between 4 and 20 characters long";
    }

    if (!ctype_alnum($username)) {
        return "ERROR: Username must only contain letters and numbers";
    }

    // Verify email
    if (!isset($request['email'])) {
        return "ERROR: No email provided";
    }

    $email = trim($request['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "ERROR: Invalid email format";
    }

    // Hash password
    if (!isset($request['password'])) {
        return "ERROR: No password provided";
    }

    $password = trim($request['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $validatedRequest = array(
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword
    );

    // Send validated request to database
    return queryDatabase($validatedRequest);
}

function requestProcessor($request)
{
    echo "received request".PHP_EOL;
    var_dump($request);

    switch ($request['type'])
    {
        case "register":
            return registerUser($request);
        case "login":
            return queryDatabase($request);
    }

    echo "couldn't get message";
    return "couldn't get message";
}

function checkconnection(){
    for($x = 0; $x < 3; $x++){
        if ($x == 0){
            $server1 = new rabbitMQServer("registerQ.ini","testServer");
            echo "Server 1 Starting" . PHP_EOL;
            $server1->process_requests('requestProcessor');
        }
        elseif($x == 1){
            $server2 = new rabbitMQServer("./rmq/login2.ini","testServer");
            echo "Server 2 Starting" . PHP_EOL;
            $server2->process_requests('requestProcessor');
        }
        else{
            $server3 = new rabbitMQServer("./rmq/login3.ini","testServer");
            echo "Server 3 Starting" . PHP_EOL;
            $server3->process_requests('requestProcessor');
        }
    }
}

checkconnection();

