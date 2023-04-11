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
  echo "$email\n";
  if (empty($email)) {
    echo "Email must not be empty";
    $isValid = false;
  }
  if (!preg_match($emailPattern, $email)) {

    echo "Invalid email entered";
    $isValid = false;
  }
  if (empty($username)) {
    echo "Username must not be empty";
    $isValid = false;
  }
  if (!preg_match($usernamePattern, ($username))) {
    echo "Username must be lowercase, alphanumerical, and can only contain  or -";
    $isValid = false;
  }
  if (strlen($password) < 8) {
    echo "Password must be at least 8 characters";
    $isValid = false;
  }
  return $isValid;
}
function doRegister($email, $username, $password)
{
  $con = dbconnect();

  if (!doValidation($email, $username, $password)) {
    echo 'The credentials have not been validated.';
  } else {
    $query = "SELECT * FROM accounts WHERE username='$username'";
    $result = $con->query($query);
    if ($result->num_rows == 1) {
      // username have duplicate entries in database
      echo 'Username already taken.';
      return false;
    } else {
      // password being hashed security purpose
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $insert = "INSERT IGNORE INTO accounts (email, username, password) VALUES ('$email', '$username', '$hashed_password')";
      if ($con->query($insert)) {
        echo "New user successfully entered into database.";
        return true;
      } else {
        echo "Failed to insert new user. Connection error: ";
        $con->error;
        return false;
      }
    }
  }
}


function doLogin($email, $password)
{
  $con = dbconnect();

  $query = "SELECT * FROM accounts WHERE email='$email' ";
  $result = $con->query($query);


  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $user['password'])) {
      // Password is correct, return success message and user data
      /*return array(
        'status' => 'success',
        'message' => 'Login successful',
        'user' => array(
          'id' => $user['id'],
          'email' => $user['email']
        )
      );*/
      return true;
    } else {
      // Password is incorrect, return error message
      //return array('status' => 'error', 'message' => 'Invalid username or password');
      return false;
    }
  } else {
    // Username not found, return error message
    //return array('status' => 'error', 'message' => 'Invalid username or password');
    return false;
  }
}