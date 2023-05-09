<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('dbconnect.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;



function doValidationScore($email)
{
  $isValid = true;
  $emailPattern = '/^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/';
  if (empty($email)) {
    echo "Email must not be empty";
    $isValid = false;
  }
  if (!preg_match($emailPattern, $email)) {

    echo "Invalid email entered";
    $isValid = false;
  }
  return $isValid;
}
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
  //$con2 = dbconnect();

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
      /* if ($con2->query($insert)) {
      echo "New user successfully entered into database.";
      return true;
      } else {
      echo "Failed to insert new user. Connection error: ";
      $con2->error;
      return false;
      }*/
    }
  }
}


function doLogin($email, $password)
{
  $con = dbconnect();
  //$con2 = dbconnect();


  $query = "SELECT * FROM accounts WHERE email='$email' ";
  //$result = $con->query($query);
  $result2 = $con->query($query);

  if ($result2->num_rows > 0) {
    $user = $result2->fetch_assoc();

    // Verify the password
    if (password_verify($password, $user['password'])) {

      return true;
    } else {
      // Password is incorrect, return error message
      return false;
    }
  } else {
    // Username not found, return error message
    return false;
  }
  if ($result2->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $user['password'])) {
      return true;
    } else {
      // Password is incorrect, return error message
      return false;
    }
  } else {
    // Username not found, return error message
    return false;
  }
}



function doInsertHighScore($email, $highscore)
{
  $con = dbconnect();
  if (!doValidationScore($email)) {
    echo 'The credentials have not been validated.';

  } else {
    $query = "SELECT * FROM accounts WHERE email='$email'";
    $result = $con->query($query);
    if ($result->num_rows == 1) {
      // username have duplicate entries in database
      echo 'Email exists, proceed with score insertion.';
      // password being hashed security purpose
      $insert = "INSERT IGNORE INTO scores (score_email, score) VALUES ('$email', '$highscore')";
      if ($con->query($insert)) {
        echo "New score successfully inserted into database.\n";
        return true;
      } else {
        echo "Failed to insert score. Connection error: \n";
        $con->error;
        return false;
      }
    } else {
      echo "Could not insert score into SCORES table. Exiting... \n";
      return false;
    }
  }
}

function getHighScores()
{
  // Connect to the database
  $con = dbconnect();

  // Query the database for the top 10 highest scores with corresponding usernames
  $query = "SELECT a.id AS ID_Number, a.username AS Username, s.score AS Highscore, s.created AS Date FROM accounts a JOIN scores s ON a.email = s.score_email WHERE s.score = (SELECT MAX(score) FROM scores WHERE score_email = a.email) ORDER BY Highscore DESC LIMIT 10;";
  $result = $con->query($query);
  echo "1\n";

  // Process the results into an associative array
  $scores = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $scores[] = array(
      "username" => $row["Username"],
      "score" => $row["Highscore"]
    );
  }
  print_r($scores);
  return $scores;

}



function getUserHighScores($email)
{
  // Connect to the database
  $con = dbconnect();

  $query = "SELECT scores.score AS 'Scores', scores.created AS 'Date' FROM scores JOIN accounts ON scores.score_email = accounts.email WHERE accounts.email = '$email' ORDER BY scores.score DESC LIMIT 10;";
  $result = $con->query($query);

  // Process the results into an associative array
  $scores = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $scores[] = array(
      "score" => $row["Scores"],
      "date" => $row["Date"]
    );
  }
  print_r($scores);

  return $scores;
}


function doValidation2($password)
{
  $isValid = true;
  if (strlen($password) < 8) {
    echo "Password must be at least 8 characters";
    $isValid = false;
  }
  return $isValid;
}

function doUpdatePassword($email, $newpassword)
{
  $con = dbconnect();

  if (!doValidation2($newpassword)) {
    echo 'The password has not been validated.';
  } else {
    $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
    echo 'The password has been validated and hashed.';
    echo 'This is the password:' . $hashed_password;
    $update = "UPDATE accounts SET password = '$hashed_password' WHERE email = '$email'";
    if ($con->query($update)) {
      echo "Password updated";
      return true;
    } else {
      echo "Failed to update password: " . $con->error;
      return false;
    }
  }
}