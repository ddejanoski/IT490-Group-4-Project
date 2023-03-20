<?php 
include('/home/nicole/Documents/IT490/RabbitMQClientRegister.php'); 
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Register </title>
        <link rel="stylesheet" type="text/css" href="styles.css"></link>
    </head>

    <body>
        <div class="registerform">
        <img src="pictures/prois-logo.png" class="avatar">
            <h2>Register!</h2>
            <form onsubmit="return validate(this)" id="register" method="GET" name="register" action="/register.php">
                <p>Email</p>
                <input type="email" name="email" value ="damjan@email.com" id="email" placeholder="email@example.com" required />
                <p>Create Username</p>
                <input type="text" name="username" value="damjanswindmill" id="username" placeholder="Enter Username" required maxlength="30" />
                <p>Create Password</p>
                <input type="password" name="password" value="password" id="password" placeholder="Enter Password"  />
                <p>Confirm Password</p>
                <input type="password" name="confirm" placeholder="Confirm password" value="password" required minlength="8"/>
                <input type="submit" name="register" value="register" id="register" />
                <a href="login.php"> Already have an account? Login! </a>
            </form>
        </div>
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
        if(document.register.password.length < 8){
            alert("Password must be at least 8 characters");
            isValid = false;
        }
        if(document.register.password.value !== document.register.confirm.value){
            alert("Password confirmation must be at least 8 characters");
            isValid = false;
        }
        if(document.register.password.value !== document.register.confirm.value){
            alert("Password and Confirm Password must match");
            isValid = false;
        }

        return isValid; 
    }
</script> 