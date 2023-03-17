<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('dbconnect.php');

function doRegister($email, $username, $password)
{
  
echo "$email, $username, $password, 1st ";
global $con;
$host_name = '172.25.153.116';
$user_name = 'brian';
$password = 'DBpasswordBACKEND123';
$database_name = 'test';
$message_connected = $user_name . ' has successfully connected to ' . $database_name;
$message_failed = $user_name . "'s connection to " . $database_name . ' has failed.';

$con = mysqli_connect($host_name, $user_name, $password, $database_name);
echo "$email, $username, $password, 2nd";
if (mysqli_connect_errno()) {
	die($message_failed);
}
else {
	echo $message_connected;
}
/*
  $query = "SELECT * FROM Accounts WHERE email = :email OR username = :username";
  $stmt = $con->prepare($query);
*/
echo "$email, $username, $password, 3rd";
  $query = "SELECT * FROM Accounts WHERE username='$username'";
  $result = $con->query($query);
  if ($result->num_rows == 1) {
    // username or email already taken, return error message
    echo 'Username or email already taken';
  } else {
    echo "$email, $username, $password, 4th";
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

    // insert the new user into the database
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT); // hash the password for security
    $sql = "INSERT INTO Accounts (email, username, password) VALUES ('$email', '$username', '$password')";
    echo "$email, $username, $password, 5th";
  }
  if ($con->query($sql)) {
    echo "$email, $username, $password, 6th";
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }
  
}

/*function doLogin($username, $password)

  $conn = dbConnection();

  $query = "SELECT * FROM Accounts WHERE username=?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $user['password'])) {
      // Password is correct, return success message and user data
      return array(
        'status' => 'success',
        'message' => 'Login successful',
        'user' => array(
          'id' => $user['id'],
          'email' => $user['email'],
          'username' => $user['username']
        )
      );
    } else {
      // Password is incorrect, return error message
      return array('status' => 'error', 'message' => 'Invalid username or password');
    }
  } else {
    // Username not found, return error message
    return array('status' => 'error', 'message' => 'Invalid username or password');
  }
}*/