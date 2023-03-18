<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('dbconnect.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


function doValidation($email, $username, $password)
{
    $isValid = true;
    $emailPattern = '/^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/';
    $usernamePattern = '/^[a-z0-9-]{3,30}$/';

    if (empty($email['email'])) {
        echo "Email must not be empty";
        $isValid = false;
    }
    if (!preg_match($emailPattern, $email['email'])) {
        echo "Invalid email entered";
        $isValid = false;
    }
    if (empty($username['username'])) {
        echo "Username must not be empty";
        $isValid = false;
    }
    if (!preg_match($usernamePattern, ($username['username']))) {
        echo "Username must be lowercase, alphanumerical, and can only contain  or -";
        $isValid = false;
    }
    if (strlen(($password['password'])) < 8) {
        echo "Password must be at least 8 characters";
        $isValid = false;
    }
    return "isValid";
}
function doRegister($email, $username, $password)
{
  $con = dbconnect();
  
  if (!doValidation($email, $username, $password)){
    echo 'not validate';
  }else {
  $query = "SELECT * FROM Accounts WHERE username='$username'";
  $result = $con->query($query);
  if ($result->num_rows == 1) {
    // username or email already taken, return error message
    echo 'Username or email already taken';
  } else {
    // insert the new user into the database
    // hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);// hash the password for security
    $content = array($email, $username,$hashed_password);
    $insert = "INSERT IGNORE INTO Accounts (email, username, password) VALUES ('$email', '$username', '$hashed_password')"; 
    
}



function doLogin($username, $password)
{
  $con = dbconnect();


  $query = "SELECT * FROM Accounts WHERE username='$username'";
  $result = $con->query($query);

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
}