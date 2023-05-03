<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function buildTable($array){
    $html = 'table';

    $html .= '<tr>';
    foreach($array[0] as $key=>$value){
        $html .= '<th>' . htmlspecialchars($key) . '</th>';
    }

    $html .= '</tr>';

    foreach($array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</table>';
    return $html;
}

$client = new rabbitMQClient("gameRMQ.ini","testServer");

$request = array();
$request['type'] = "userScoreboard";
$request['email'] = $_SESSION["email"];
$request['message']  = $msg;
	
$response = $client->send_request($request);	

if ($response==0){
	echo '<script>alert("Something went wrong with scoreboard retrieval")</script>';
}
else{ 
	buildTable($response);
}
?>