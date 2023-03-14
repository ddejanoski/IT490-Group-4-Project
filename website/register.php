<?php 
include('/home/nicole/Documents/IT490/RabbitMQClient.php'); 
reset_session();
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
        var isValid = true;
        var e_valid = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        var u_valid = /^[a-z0-9_-]{3,30}$/;

        if(document.register.email.value == ""){
            alert("Email must not be empty");
            isValid = false;
        }
        if(!e_valid.test(document.register.email.value)){
            alert("Invalid email entered");
            isValid = false;
        }
        if(document.register.username.value == ""){
            alert("Username must not be empty");
            isValid = false;
        }
        if(!u_valid.test(document.register.username.value)){
            alert("Username must be lowercase, alphanumerical, and can only contain _ or -");
            isValid = false;
        }
        if(document.register.pw.length < 8){
            alert("Password must be at least 8 characters");
            isValid = false;
        }
        if(document.register.pw.value !== document.register.confirm.value){
            alert("Password confirmation must be at least 8 characters");
            isValid = false;
        }
        if(document.register.pw.value !== document.register.confirm.value){
            alert("Password and Confirm Password must match");
            isValid = false;
        }

        return isValid;
    }
</script>