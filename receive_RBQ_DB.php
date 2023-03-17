<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include the RabbitMQ client library

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Set up the connection to the RabbitMQ server
$connection = new AMQPStreamConnection('172.25.214.177', 5672, 'admin', 'admin');
$channel = $connection->channel();

// Declare the queue to listen on
$channel->queue_declare('my_queue', false, true, false, false);

// Define the callback function to handle incoming messages
$callback = function(AMQPMessage $message) {
    // Extract the data from the message
    $data = json_decode($message->body, true);

    // Store the data in the database
    $servername = "localhost";
    $username = "my_username";
    $password = "my_password";
    $dbname = "my_database";

    // Create a new connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the data into the database
    $stmt = $conn->prepare("INSERT INTO Accounts (auth0_id, email, username, is_online) VALUES (:auth0_id, :email, :username, :is_online)");
    $stmt->bind_param("sss", $data['auth0_id'], $data['email'], $data['username'], $data['is_online']);
    $stmt->execute();
    $stmt->close();
    $conn->close();
};

// Start consuming messages from the queue
$channel->basic_consume('my_queue', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

// Close the connection to the RabbitMQ server
$channel->close();
$connection->close();
?>
