<?php 
include('/home/nicole/Documents/IT490/RabbitMQClientLogin.php'); 
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
            <form onsubmit="return validate(this)" id="login" method="GET" name="login" action="/login.php">
                <p>Email</p>
                <input type="email" name="email" id="email" placeholder="email@example.com" required />
                <p>Password</p>
                <input type="password" name="password" id="password" placeholder="Enter Password" required minlength="8" />
                <input type="submit" name="login" value="login" id="login" />
                <a href="login.php"> Don't have an account? Register! </a>
            </form>
        </div>
    </body>

</html>

<script>
    function validate(form) {
        var isValid = true;

        if(document.login.email.value == ""){
            alert("Email or username must not be empty");
            isValid = false;
        }
        if(document.login.password.length < 8 ){
            alert("Password must be at least 8 characters");
            isValid = false;
        }

        return isValid;
    }
</script>