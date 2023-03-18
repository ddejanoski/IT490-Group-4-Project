<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('dbconnect.php');
require_once('function.php');

function validate($request)
{
    $isValid = true;
    $emailPattern = '/^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/';
    $usernamePattern = '/^[a-z0-9-]{3,30}$/';

    if (empty($request['email'])) {
        echo "Email must not be empty";
        $isValid = false;
    }
    if (!preg_match($emailPattern, $request['email'])) {
        echo "Invalid email entered";
        $isValid = false;
    }
    if (empty($request['username'])) {
        echo "Username must not be empty";
        $isValid = false;
    }
    if (!preg_match($usernamePattern, ($request['username']))) {
        echo "Username must be lowercase, alphanumerical, and can only contain  or -";
        $isValid = false;
    }
    if (strlen(($request['password'])) < 8) {
        echo "Password must be at least 8 characters";
        $isValid = false;
    }
    return "isValid";
}


function requestProcessor($request)
{
    echo "received request" . PHP_EOL;
    var_dump($request);
    if (!isset($request['username'])) {
        return "ERROR: No username provided";
    }
    switch ($request['type']) {
        case "register":
            $validationResult = validate($request);
            if ($validationResult == true) {
                //hashing
                $password_to_hash = $request['password'];
                $hashed_password = password_hash($password_to_hash, PASSWORD_BCRYPT);

                $update_request = array();
                $update_request['email'] = $request["email"];
                $update_request['username'] = $request["username"];
                $update_request['password'] = $hashed_password;

                // Code to insert registration information into database would go here
                echo "check for hitting db function\n";
                $client = new rabbitMQClient("RabbitMQ_db.ini", "testServer");
                echo "initializing RMQ client\n";
                echo "sending retrieved message to db server unbothered\n";
                $response = $client->send_request($update_request);
                echo "sending response back to client...\n" . var_dump($response);
                return $response;
                echo "Registration successful";
            } else {
                header('location: register.php');
                return $validationResult;
            }
        default:
            return "ERROR: Invalid request type";
    }
}


function checkconnection()
{

    $server1 = new rabbitMQServer("register.ini", "testServer");
    echo "Server 1 Starting" . PHP_EOL;
    $server1->process_requests('requestProcessor');
}



checkconnection();

?>