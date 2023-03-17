<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


$connection = new AMQPStreamConnection('172.25.214.177', 5672, 'admin', 'admin');
$channel = $connection->channel();


$channel->queue_declare('my_queue', false, true, false, false);


$data = array()
?>
