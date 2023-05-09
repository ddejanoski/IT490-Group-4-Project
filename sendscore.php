<?php 
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('172.25.214.177',5672, 'admin', 'admin');
$channel = $connection->channel();


$queueName = 'queueScore';

$channel->queue_declare($queueName, false, false, false, false);

$scores = getHighScores();
$messageBody = json_encode($scores);
$message = new AMQPMessage($messageBody);
$channel->basic_publish($message, '', $queueName);
$channel->close();
$connection->close();

?>