<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!$_SESSION['id']) {
    header("Location:login.php");
}
include "connectionDB.php";
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';


var_dump($_GET);
$user_id = $_GET["id"];

$users = file('users.txt');

$db = new Database('localhost', 'phplabs', 'root', '12345');
$conn = $db->connect();

if ($conn) {
    $db->delete('users',$user_id);

    if ($_SESSION["id"] == $user_id) {
        header("Location:logout.php");
    } else {
        header("Location:dataOfUser.php");
    }


} else {
    header("Location:dataOfUser.php");
}

//header("Location:dataOfUser.php");