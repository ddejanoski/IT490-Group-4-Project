<?php
$servername = "172.25.153.116";
$username = "brian";
$password = "DBpasswordBACKEND123";
$dbname = "test";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert test data into the database
$sql = "INSERT INTO Accounts (email, username, password) VALUES ('john@example.com', 'John Doe', '12345678')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>