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
  var_dump($request);
  if (!isset($request['username'])) {
    return "ERROR: No username provided";
  }
  switch ($request['type']) {
    case "register":
      $response_msg = doRegister($request['email'], $request['username'], $request['password']);
      return $response_msg;
  }
  echo "couldn't get message";
  return "couldn't get message";
}

$server = new rabbitMQServer("RabbitMQ_db.ini", "testServer");

echo "dbServer BEGIN" . PHP_EOL;
$server->process_requests('requestProcessor');
echo "dbServer END" . PHP_EOL;
exit();
?>