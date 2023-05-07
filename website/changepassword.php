<?php
include('/home/nicole/Documents/IT490/RabbitMQClientPassword.php');
?>

<!DOCTYPE html>

<html>
<head>
        <title> Password Change </title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

<body>
        <div class="changepasswordform">
        <img src="pictures/prois-logo.png" class="avatar">
            <h2>Change your password</h2>
            <form onsubmit="return validate(this)" id="changepwd" method="GET" name="changepwd" action="/changepassword.php">
                <p>Old Password</p>
                <input type="password" name="oldpassword" id="oldpassword" placeholder="Enter Old Password" required minlength="8" />
                <p>New Password</p>
                <input type="password" name="newpassword" id="newpassword" placeholder="Enter New Password" required minlength="8" />
                <p>Confirm New Password</p>
                <input type="password" name="confirm" placeholder="Confirm password" required minlength="8"/>
                <input type="submit" name="changepwd" value="Submit" id="changepwd" />
            </form>
        </div>
    </body>
</html>

<script>
    function validate(form) {
        var isValid = true;

        if(document.changepwd.newpassword.length < 8){
            alert("Password must be at least 8 characters");
            isValid = false;
        }
        if(document.changepwd.confirm.length < 8){
            alert("Password must be at least 8 characters");
            isValid = false;
        }
        if(document.changepwd.newpassword.value !== document.changepwd.confirm.value){
            alert("New Password and Confirm Password must match");
            isValid = false;
        }

        return isValid; 
    }
</script>