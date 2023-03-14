<?php 
include('/home/nicole/Documents/IT490/RabbitMQClient.php'); 
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Login </title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <div class="loginform">
        <img src="pictures/prois-logo.png" class="avatar">
            <h2>Login!</h2>
            <form onsubmit="return validate(this)" method="POST">
                <p>Email</p>
                <input type="email" name="email" placeholder="email@example.com" required>
                <p>Password</p>
                <input type="password" name="pw" placeholder="Enter Password" required minlength="8">
                <input type="submit" name="submitlogin" value="login">
                <a href="login.php">Don't have an account? Register! </a>
            </form>
    </body>

</html>

<script>
    function validate(form) {
        //insert validation here
        var isValid = true;
        return isValid;
    }
</script>