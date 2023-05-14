<?php

// require_once('../../config/database.php');
include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/user_controller.php");


$UserController = new UserController();

if (!empty($_POST["sub"])) {
}

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirm"];
$roomID = $_POST["room_id"];
$ext = $_POST["ext_attr"];

$errors = [];
$formdata = [];

//var_dump($roomID);
//exit();
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
} elseif ($_GET['method'] == "add" && !preg_match('/^[a-z0-9_]*$/', $password)) {
    $errors["password"] = "password must contain only small letters, numbers, and underscores";
} else {
    $formdata["password"] = $password;
}

if (empty($confirmPassword) and isset($confirmPassword)) {
    $errors["confirm"] = "Confirm password is Required";

} else {
    if ($confirmPassword != $password) {
        $errors["confirm"] = "Password isn't matched";
    } else {

        $formdata["confirm"] = $confirmPassword;
    }
}

if ($roomID == "0") {
    $errors["room_id"] = "NO.ROOM is Required";
} else {
    $formdata["room_id"] = $roomID;
}

if (empty($ext) and isset($ext)) {
    $errors["ext_attr"] = "Ext is Required";
} else {
    $formdata["ext_attr"] = $ext;
}

if ($errors) {
    $errors_str = json_encode($errors);

    if ($_GET['method' == "add"]) {
        $url = "Location:/CafeteriaSystem/views/admin/users/addUser.php?errors={$errors_str}";
    } else {
        $url = "Location:/CafeteriaSystem/views/admin/users/editUser.php?errors={$errors_str}";
    }

    if ($formdata) {
        $old_data = json_encode($formdata);
        $url .= "&old={$old_data}";
    }
    header($url);
} else {

    if ($_GET['method'] == "add") {
        $result = $UserController->store();
        $response = json_decode($result, true);
    } else {
        $result = $UserController->update($_GET["id"]);
        $response = json_decode($result, true);
    }
    if ($response["status"] == "success") {
        header("Location: /CafeteriaSystem/views/admin/users/displayUsers.php");
    }
}

