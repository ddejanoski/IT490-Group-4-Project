#!/usr/bin/php
<?php
session_start();

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('dbconnect.php');
require_once('function.php');


function requestProcessor($request)
{
  echo "received request" . PHP_EOL;
  echo $request['type'] . PHP_EOL;
  var_dump($request);

  if (!isset($request['type'])) {
    //return "ERROR: unsupported message type";
    return array('message' => "ERROR: unsupported message type");
  }


  if ($request['type'] == "register") {
    echo "\n*Type: Registration\n";
    $response_msg = dochecking($request['email'], $request['username'], $request['password']);
  } else {
    $response_msg = "something else";
  }
  return $response_msg;

  if ($request['type'] == "login") {
    echo "\n*Type: Login\n";
    $response_msg = doLogin($request['email'], $request['username'], $request['password']);
  } else {
    $response_msg = "something else";
  }
  return $response_msg;



}

$server = new rabbitMQServer("RabbitMQ_db.ini", "testServer");

echo "dbServer BEGIN" . PHP_EOL;
$server->process_requests('requestProcessor1');
echo "dbServer END" . PHP_EOL;
exit();
?>