<?php
session_start();

require_once __DIR__ . 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include ('functions.php');

//Check if name is entered
    $passhash = password_hash($_POST['password'], PASSWORD_DEFAULT);    //Hashing password

    $content = array(
        "name" => $_POST['name'],
        "email" => $_POST['email'],
        "pass" => $passhash,
        "type" => $_POST['register']
    );

$msgJson = json_encode($content);

//connecting to rabbitmq
$connection = new AMQPStreamConnection('172.25.214.177', 5672, 'admin', 'admin');
$channel = $connection->channel();
//declaring queue named hello
$channel->queue_declare('email', false, false, false, false);

$msg = new AMQPMessage($msgJson, array('delivery_mode' => 2 ));
//publishing message from the register form to rabbitmq
$channel->basic_publish($msg, '', 'email');

echo "Sent to RabbitMQ: ";

header("location: login.html?msg=User ".  $_POST['name'] . " is registered");


$channel->close();
$connection->close();