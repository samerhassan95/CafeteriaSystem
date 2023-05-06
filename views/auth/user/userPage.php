<?php
session_start();
require_once('../../navbar.php');

if (!isset($_SESSION["email"])) {
    header("Location:../alertPage.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>This Is User Page</h1><?php echo  $_SESSION["email"] ?>
    <a href="../logout.php">Logout</a>
</body>

</html>