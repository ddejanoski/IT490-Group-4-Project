<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

if(isset($_POST['score'])){
    $client = new rabbitMQClient("gameRMQ.ini","testServer");

    $request = array();
    $request['type'] = "score";
    $request['email'] = $_SESSION["email"];
    $request['score'] = $_POST['score'];

    $request['message'] = $msg;

    $client->publish($request);
}
?>