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
  echo "received request\n";
  echo $request['type'];
  
  if (!isset($request['type'])) {
    return array('message' => "ERROR: unsupported message type");
  }


  if ($request['type'] == "changepassword") {
    echo "\n*Type: changepassword\n";
    $response_msg = doUpdatePassword($request['email'], $request['newpassword']);
  } else {
    $response_msg = "false";
  }
  return $response_msg;
}

$server = new rabbitMQServer("changpwd.ini", "testServer");


echo "dbServer BEGIN\n";
$server->process_requests('requestProcessor');
echo "dbServer END\n";
exit();
?>