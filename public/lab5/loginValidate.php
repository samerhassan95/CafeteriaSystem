<?php

include "connectionDB.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$email = $_POST["email"];
$password = $_POST["password"];


$errors = [];
$formdata = [];

if (empty($email)) {

    $errors['email'] = 'email is required';
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL) or !preg_match("/^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/", $email)) {
    $errors['email'] = 'email not valid make sure it has format like \"exammple123@gmail.com\"';
} else {
    $formdata["email"] = $email;
}

if (empty($password) and isset($password)) {
    $errors["password"] = "Password is required";
} else {
    $formdata["password"] = $password;
}

if ($errors) {
    $errors_str = json_encode($errors);
    $url = "Location:login.php?errors={$errors_str}";
    if ($formdata) {
        $old_data = json_encode($formdata);
        $url .= "&old={$old_data}";
    }
    header($url);
} else {


    try {
        $logged = false;


        $db = new Database('localhost', 'phplabs', 'root', '12345');
        $db->connect();

        $res = $db->selectUser('users','Email',$email);
        if ($res["Email"]) {
            if (trim($res["Email"]) == trim($email) and trim($res["password"]) == trim($password)) {
                $logged = true;
            }

            if ($logged) {
                session_start();
                $_SESSION['id'] = $res["id"];
                $_SESSION['logged'] = true;
            } else {

                header("Location:login.php?message=invalid data");
            }
            header("Location:dataOfUser.php");
        } else {
            header("Location:login.php?message=invalid data");
        }


    } catch (Exception $e) {
        echo $e->getMessage();
    }

}