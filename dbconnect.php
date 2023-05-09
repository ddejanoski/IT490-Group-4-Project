<?php
function dbconnect()
{
	$host_name = '172.25.153.116';
	$user_name = 'backend';
	$password = 'DBpasswordBACKEND123';
	$database_name = 'test';
	$message_connected = $user_name . ' has successfully connected to ' . $database_name;
    $message_failed = $user_name . "'s connection to " . $database_name . ' has failed.';

    $con = mysqli_connect($host_name, $user_name, $password, $database_name);


    if (mysqli_connect_errno()) {
        die($message_failed);
    }
    else {
        echo $message_connected;
    }
    return $con;

}
/*function dbconnect2()
{
    $host_name = '172.25.217.136';
	$user_name = 'backend';
	$password = 'DBpasswordBACKEND123';
	$database_name = 'test';
	$message_connected = $user_name . ' has successfully connected to BACKUP ' . $database_name;
    $message_failed = $user_name . "'s connection to BACKUP " . $database_name . ' has failed.';


    $con2 = mysqli_connect($host_name, $user_name, $password, $database_name);

    if (mysqli_connect_errno())
    {
    echo "Failed to connect to BACKUP MySQL: " . mysqli_connect_error();
    }
    else{
        echo"Successfully connected to BACKUP database!";
    }
    return $con2;
}*/




