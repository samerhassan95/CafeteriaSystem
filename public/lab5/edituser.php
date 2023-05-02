<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "connectionDB.php";
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';


$usersNewData = [];
$user_id = $_GET["id"];
$f_name = $_POST["fname"];
$l_name = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$gender = $_POST["gender"] ?? null;
$username = $_POST["username"];
$department = $_POST["department"];
$address = $_POST["address"];
$country = $_POST["country"];
$skills = $_POST["skills"] ?? null;
$arrLength = $_POST["skills"] ? count($skills) : 0;


if (isset($_FILES['image']) and !empty($_FILES['image']['name'])) {
    $tmpName = $_FILES['image']['tmp_name'];
    $extension = pathinfo($_FILES['image']['name'])['extension'];
    $id = time();
    $imageName = "images/$id.$extension";
    if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
        $uploaded = move_uploaded_file($tmpName, $imageName);
    }
} else {
    $imageName = 'images/userPlaceHolder.jpg';
}

$user_skills = "";
if (!empty($skills)) {
    foreach ($skills as $skill) {
        $user_skills .= "$skill,";
    }
    $user_skills = substr($user_skills, 0, -1);
} else {
    $user_skills = "No skills";
}

$db = new Database('localhost', 'phplabs', 'root', '12345');
$conn = $db->connect();

if ($conn) {

    $res = $db->update('users',
        ["FirstName", "LastName", "Email", "Gender", "username", "department", "address", "country", "skills", "image", "password"],
        [$f_name, $l_name, $email, $gender, $username, $department, $address, $country, $user_skills, $imageName, $password],
        'id',
        $user_id
    );

    header("Location:dataOfUser.php");


} else {
    header("Location:login.php?message=connection error");
}
