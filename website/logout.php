<?php
session_start();
session_unset();
session_destroy();
echo '<script>alert("Successfully logged out")</script>';
header("Location: index.php");
?>
