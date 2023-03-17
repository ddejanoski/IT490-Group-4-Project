<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Creates Rabbit client for the DB query requests
function createClientDB($request){
        $client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
        
        if(isset($argv[1])){
            $msg = $argv[1];
        }
        else{
            $msg = "client";
        }
        
        $response = $client->send_request($request);
        return $response;
    }