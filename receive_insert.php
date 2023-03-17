#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('db_connect.php');

function requestProcessor($request)
{

    echo "REQUEST RECEIVED, WAITING: ".PHP_EOL;
    $conn = connect_to_db();
    $email = $request['email'];
    $username = $request['username'];
    $password = $request['password'];


    if (mysqli_connect_errno())
    {
        return "You've failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        echo $username . " has successfully connected to " . $database;
        echo 'Attempting insert.';
        $query = "INSERT INTO Accounts (email, username, password) VALUES ('$email', '$username', '$password')";
        $init_user = mysqli_query($conn, $query);
        if ($init_user)
        {
            return 'Successfully inserted info.';
        }
        else
        {
            echo mysqli_error($conn) . "\n Please try again.\n";
            return 'Data not inserted.';
        }
    }
    echo $username ." you've not received a response from " . $database . " database.";
    return 'Please try again.';
}

$server = new rabbitMQServer("registerDatabase.ini","testServer");
echo "STARTED SERVER, WAITING: " . PHP_EOL;
$server->process_requests('requestProcessor');
exit();
?>
