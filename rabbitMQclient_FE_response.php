<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('172.25.214.177',5672, 'admin', 'admin');
$channel = $connection->channel();

channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('1');
$channel->basic_publish($msg, '', '1');

$channel->close();
$connection->close();
?>