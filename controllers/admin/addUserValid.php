<?php

// require_once('../../config/database.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/controllers/user_controller.php");


$UserController = new UserController();

$errors = [];
$formvalues =[];

if(!empty($_POST["sub"])) {
    if($_POST["username"]) {
        $username = $_POST["username"];
    } else {
        $errors["username"] = "username is Required";
    }

    if($_POST["email"]) {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["email"];
        } else {
            $errors["email"] = "Email is Invalid";
        }
    } else {
        $errors["email"] = "Email is Required";    
    }

    if($_POST["password"]) {
        $password = $_POST["password"];
    } else {
        $errors["password"] = "Password is Required";
    }
    
    if($_POST["confirm"]) {
        $confirm_Pass = $_POST["confirm"];
        if($confirm_Pass != $password) {
            $errors["confirm"] = "Password isn't matched";
        }
    } else {
        $errors["confirm"] = "Confirm password is Required";
    }

    if($_POST["room_id"] != "") {
        $room_id = $_POST["room_id"];
    } else {
        $errors["room_id"] = "NO.ROOM is Required";
    }
    
    if($_POST["ext_attr"]) {
        $ext_attr = $_POST["ext_attr"];
    } else {
        $errors["ext_attr"] = "NO.exit is Required";
    }
        
    $formvalues = [
        "username" => $username,
        "email" => $email,
        "room_id" => $room_id,
        "ext_attr" => $ext_attr
    ];

    if($errors) {
        var_dump($formerrors);
        $redirect_url = "Location: ../../views/auth/admin/users/addUser.php?errors={$formerrors}";
        if ($formvalues) {
            $oldvalues = json_encode($formvalues);
            $redirect_url .= "&old={$oldvalues}" ;
        }
        header($redirect_url);
    } else {
        $result = $UserController->store();
        $response = json_decode($result, true);
        if ($response["status"] == "success") {
            header("Location: ../../views/auth/admin/users/displayUsers.php");
        } 
    }

} else if (($_POST["reset"])) {
    header("Location: ../../views/auth/admin/users/addUser.php");
}

?>


