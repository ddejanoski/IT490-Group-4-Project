<?php
require(__DIR__ . "/navbar.php");
include('/home/nicole/Documents/IT490/RabbitMQClient.php');
?>

<!DOCTYPE html>

<html>
    <h1> This is the Game Page </h1>
    <p> Welcome <?php echo $_SESSION['email']; ?> </p>
    <p> Use the arrow keys to move your Professor </p>
    <p> Shoot the aliens with the spacebar and score as many points as possible </p>
</html>