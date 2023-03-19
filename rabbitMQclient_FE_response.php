<?php

require_once DIR . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

function successfulResponse() {
    $connection = new AMQPStreamConnection('172.25.214.177',5672, 'admin', 'admin');
    $channel = $connection->channel();

    $channel->queue_declare('hello', false, false, false, false);

    $msg = new AMQPMessage('1');
    $channel->basic_publish($msg, '', '1');

    $channel->close();
    $connection->close();
}

function unsuccessfulResponse() {
    $connection = new AMQPStreamConnection('172.25.214.177',5672, 'admin', 'admin');
    $channel = $connection->channel();

    $channel->queue_declare('hello', false, false, false, false);

    $msg = new AMQPMessage('0');
    $channel->basic_publish($msg, '', '0');

    $channel->close();
    $connection->close();
}
?> 