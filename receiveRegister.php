<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('172.25.214.177', 5672, 'admin', 'admin');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for backend messages. To exit press CTRL+C\n";

$message = "";

$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
    global $message;
    $message = $msg->body;
};

function giveResponse(){
    return $GLOBALS['message'];
}

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();


?>
