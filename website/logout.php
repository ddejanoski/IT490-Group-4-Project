<?php
session_start();
reset_session();
echo '<script>alert("Successfully logged out")</script>';
header("Location: login.php");
?>
