<?php

require_once('../../config/database.php');

$errors = [];
$formvalues = [];
            // Start Validation of the Users Data
if(!empty($_POST["sub"])) {
    $fields = [
        "username" => "Username",
        "email" => "Email",
        "password" => "Password",
        "confirm" => "Confirm password",
        "room_id" => "NO.ROOM",
        "ext_attr" => "NO.exit"
    ];

    foreach($fields as $field => $label) {
        if(empty($_POST[$field])) {
            $errors[$field] = "$label is Required";
        } else {
            $formvalues[$field] = $_POST[$field];
        }
    }

    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $errors["email"] = "Email is Invalid";
    }

    if($_POST["confirm"] != $_POST["password"]){
        $errors["confirm"] = "Password isn't matched";
    }


              if (isset($_FILES["img"]) && !empty($_FILES["img"]["name"])) {
                $file_name = $_FILES["img"]["name"];
                $file_size = $_FILES["img"]["size"];
                $file_tmp = $_FILES["img"]["tmp_name"];
                $file_type = $_FILES["img"]["type"];
    
                $allowed_extenstions=["png", "jpg", "jpeg"];
                $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    
                if (in_array($extension, $allowed_extenstions)) {
                    $imagespath = "images/{$file_name}";
                    $res = move_uploaded_file($file_tmp, $imagespath);
                } else {
                    $errors["img"] = "Invalid image extension, allowed extensions are png, jpg and jpeg";
                }
            } else {
                $errors["img"] = "Image is required";
            }

    $formerrors = json_encode($errors);

    if($errors) {
        var_dump($formerrors);
        $redirect_url = "Location:addUser.php?errors={$formerrors}";
        if ($formvalues) {
            $oldvalues = json_encode($formvalues);
            $redirect_url .= "&old={$oldvalues}" ;
        }
        header($redirect_url);
    }

    // End  Validation of the Users Data
    
    // Insert the Data of User inside the Database
    if(!$errors) {
        $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (`username`, `password`, `email`, `image`, `room_id`, `ext_attr`)
                VALUES (:username, :password, :email, :image, :room_id, :ext_attr)";

        $stmtinsert = $db->prepare($sql);
        $stmtinsert->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
        $stmtinsert->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmtinsert->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
        $stmtinsert->bindParam(':image', $imagespath, PDO::PARAM_STR);
        $stmtinsert->bindParam(':room_id', $_POST["room_id"], PDO::PARAM_STR);
        $stmtinsert->bindParam(':ext_attr', $_POST["ext_attr"], PDO::PARAM_INT);
        $result = $stmtinsert->execute();
        header("Location:displayUsers.php");
    }
} else if (isset($_POST["reset"])) {
    header("Location: addUser.php");
}

?>