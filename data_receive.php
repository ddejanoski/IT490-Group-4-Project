#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function requestProcessor($request)
{

    echo "received request".PHP_EOL;
    $hostname = '172.25.153.116';
    $username = 'test';
    $password = 'test';
    $database = 'test';
    $conn = mysqli_connect($hostname, $username, $password, $database);
    $email = $request['email'];
    $username = $request['username'];
    $password = $request['password'];


    if (mysqli_connect_errno())
    {
        return "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        echo "Connection successful!";
        $query = "INSERT INTO Accounts (email, username, password) VALUES ('$email', '$username', '$password')";
        $init_user = mysqli_query($conn, $query);
        if ($init_user)
        {
            echo "created\n";
            return 'created';
        }
        else
        {
            echo mysqli_error($conn) . "\n not created\n";
            return 'notCreated';
        }
    }
    echo "nothing from database";
    return 'notCreated';
}

$server = new rabbitMQServer("registerDatabase.ini","testServer");
echo "Server started" . PHP_EOL;
$server->process_requests('requestProcessor');
exit();
?>
