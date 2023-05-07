<?php 
require(__DIR__ . "/navbar.php");
//include('/home/nicole/Documents/IT490/RabbitMQClientScore.php');
?>

<html>
<head>
        <link rel="stylesheet" href="page_styles.css">
</head>

    <body>
	
    <h1> Your Profile </h1>
	<p> Need to Change Your Password? </p?>
	<a href="changepassword.php" class="button"> Click Here! </a>

    <h1> Your High Scores </h1>
    </body>
</html>

<?php 
include('/home/nicole/Documents/IT490/RabbitMQClientScore.php');
?>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

</style>