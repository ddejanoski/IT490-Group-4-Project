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
                <a href="register.php">Don't have an account? Register! </a>
            </form>
    </body>

</html>

<script>
    function validate(form) {
        var isValid = true;

        if(document.login.email.value == ""){
            alert("Email or username must not be empty");
            isValid = false;
        }
        if(document.login.pw.length < 8 ){
            alert("Password must be at least 8 characters");
            isValid = false;
        }

        return isValid;
    }
</script>