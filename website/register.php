<?php 
include('/home/nicole/Documents/IT490/RabbitMQClient.php'); 
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Register </title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <div class="registerform">
        <img src="pictures/prois-logo.png" class="avatar">
            <h2>Register!</h2>
            <form onsubmit="return validate(this)" method="POST">
                <p>Email</p>
                <input type="email" name="email" placeholder="email@example.com" required>
                <p>Create Username</p>
                <input type="text" name="username" placeholder="Enter Username" required maxlength="30">
                <p>Create Password</p>
                <input type="password" name="pw" placeholder="Enter Password" required minlength="8">
                <p>Confirm Password</p>
                <input type="password" name="confirm" placeholder="Confirm password" required minlength="8">
                <input type="submit" name="submitregister" value="Register">
                <a href="login.php">Already have an account? Login! </a>
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