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

$client = new rabbitMQClient("scoreRMQ.ini","testServer");

$request = array();
$request['type'] = "leaderboard";
$request['message']  = $msg;

$response = array();
	
$client->publish($request);

// Create a TCP/IP server socket
$server_socket = stream_socket_server('tcp://172.25.217.136:1234');

// Wait for an incoming connection
$client_socket = stream_socket_accept($server_socket);

// Read the serialized data from the socket
$data = fread($client_socket, 1024);

// Unserialize the data into an array
$array = unserialize($data);

// Process the array as needed
print_r($array);

// Close the client socket
fclose($client_socket);

// Close the server socket
fclose($server_socket);

$test = $array[0];

echo "<script>alert($array[$test])</script>";

//buildTable($response);
?>