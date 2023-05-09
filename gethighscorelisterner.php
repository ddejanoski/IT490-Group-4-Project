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

    if ($request['type'] == "leaderboard") {
        echo "\n*Type: score\n";
        $response_msg = getHighScores();
        $serialized_msg = serialize($response_msg);
        $encoded_msg = base64_encode($serialized_msg);
        return array('message' => $encoded_msg);
    }
}

$server = new rabbitMQServer("highscore.ini", "testServer");


echo "dbServer BEGIN\n";
$server->process_requests('requestProcessor');
echo "dbServer END\n";
exit();
?>