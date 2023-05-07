<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("userscoreRMQ.ini","testServer");

$request = array();
$request['type'] = "userhighscore";
$request['email'] = $_SESSION["email"];
$request['message']  = $msg;
	
$response = $client->send_request($request);

$encoded_response = $response['message'];
$decoded_response = base64_decode($encoded_response);
$unserialized_response = unserialize($decoded_response);


//buildTable($unserialized_response);
echo '<table>';
echo '<th>Score</th></tr>';
foreach ($unserialized_response as $row) {
    echo "<tr>\n";
    echo "<td>" . $row['score'] . "</td>\n";
    echo "</tr>\n";
}
echo '</table>';
?>