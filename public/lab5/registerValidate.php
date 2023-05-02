<?php

include "connectionDB.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';


$f_name = $_POST["fname"];
$l_name = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$gender = $_POST["gender"] ?? null;
$username = $_POST["username"];
$department = $_POST["department"];
$address = $_POST["address"];
$country = $_POST["country"];
//$room = $_POST['room'];
$skills = $_POST["skills"] ?? null;
$arrLength = $_POST["skills"] ? count($skills) : 0;


$errors = [];
$formdata = [];

if (!empty($f_name)) {

    $formdata["fname"] = $f_name;
} else {
    $errors['fname'] = 'first Name is required';
}

if (!empty($l_name)) {

    $formdata["lname"] = $l_name;
} else {
    $errors['lname'] = 'last Name is required';
}

if (!empty($username)) {

    $formdata["username"] = $username;
} else {
    $errors['username'] = 'UserName is required';
}

if (empty($email)) {

    $errors['email'] = 'email is required';
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL) or !preg_match("/^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/", $email)) {
    $errors['email'] = 'email not valid make sure it has format like \"exammple123@gmail.com\"';
} else {
    $formdata["email"] = $email;
}

if (empty($password) and isset($password)) {
    $errors["password"] = "Password is required";
} elseif (strlen($password) <= '8') {
    $errors["password"] = "Password is not valid must be more than 8 characters";
} elseif (!preg_match('/^[a-z0-9_]*$/', $password)) {
    $errors["password"] = "password must contain only small letters, numbers, and underscores";
} else {
    $formdata["password"] = $password;
}

if (!empty($department)) {

    $formdata["department"] = $department;
} else {
    $errors['department'] = 'Department is required';
}

if (!empty($address)) {

    $formdata["address"] = $address;
} else {
    $errors['address'] = 'Address is required';
}

if (!empty($gender)) {
    $formdata["gender"] = 'checked';
} else {
    $errors['gender'] = 'Gender is required';
}

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

if ($errors) {
    $errors_str = json_encode($errors);
    $url = "Location:register.php?errors={$errors_str}";
    if ($formdata) {
        $old_data = json_encode($formdata);
        $url .= "&old={$old_data}";
    }
    header($url);
} else {

    try {


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
        $db->connect();

        $res = $db->insert('users',
            ["FirstName", "LastName", "Email", "Gender", "username", "department", "address", "country", "skills", "image", "password"],
            [$f_name, $l_name, $email, $gender, $username, $department, $address, $country, $user_skills, $imageName, $password],
        );

        header('Location:login.php');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}