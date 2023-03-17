<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('dbconnect.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

function doRegister($email, $username, $password)
{
  $con = dbconnect();
/*
  $query = "SELECT * FROM Accounts WHERE email = :email OR username = :username";
  $stmt = $con->prepare($query);
*/
echo "$email, $username, $password, 1st\n";
  $query = "SELECT * FROM Accounts WHERE username='$username'";
  $result = $con->query($query);
  if ($result->num_rows == 1) {
    // username or email already taken, return error message
    echo 'Username or email already taken';
  } else {
    echo "$email, $username, $password, 2nd\n";
    // insert the new user into the database
    // hash the password for security
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);// hash the password for security
    $content = array(
        "username" => $_POST['username'],
        "email" => $_POST['email'],
        "pass" => $hashed_password,
        "type" => $_POST['register']
    );
}
    $msgJson = json_encode($content);
    echo "$email, $username, $password, 3rd\n";
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
$con = new AMQPStreamConnection('172.25.214.177', 5672, 'admin', 'admin');
$channel = $con->channel();
//declaring queue named hello
$channel->queue_declare('email', false, false, false, false);

$msg = new AMQPMessage($msgJson, array('delivery_mode' => 2 ));
//publishing message from the register form to rabbitmq
$channel->basic_publish($msg, '', 'email');

echo "Sent to RabbitMQ: ";

header("location: login.html?msg=User ".  $_POST['username'] . " is registered");



$channel->close();
$connection->close();
