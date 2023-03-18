<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Creates Rabbit client for the DB query requests
        $client = new rabbitMQClient("RabbitMQ_db.ini", "testServer");
        
        if(isset($argv[1])){
            $msg = $argv[1];
        }
        else{
            $msg = "client";
        }
        
if(isset($content)){
    $content = array($email, $username,$hashed_password);
    $response = $client->send_request($content);
    
    header('location: index.php');

    if ($response==1){
        //echo "<strong>Registration Succesful</strong>";
        $_SESSION['username'] = $content['username'];
        $_SESSION['success'] = "You are now logged in";
        $_SESSION['json'] = json_decode($content);
        header('location: index.php');
    }
    else{ 
        array_push($errors, "User already exists"); 
    }
}
echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";
    