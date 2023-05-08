<?php
// controllers/user_controller.php

require_once(__DIR__ . '/../models/user_model.php');

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(require_once($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/config/database.php"));
    }

    public function index()
    {
        return $this->userModel->getAllUsers();
    }

    public function getUserByID($id)
    {
        return $this->userModel->getUserById($id);
    }

    public function create()
    {
        require_once(__DIR__ . '/../views/user/create.php');
    }

    public function store()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $image = isset($_POST['image']) ? $_POST['image'] : null;
        $room_id = $_POST['room_id'];
        $ext_attr = $_POST['ext_attr'];
        $total_amount_price = isset($_POST['total_amount_price']) && $_POST['total_amount_price'] !== '' ? $_POST['total_amount_price'] : null;
        $is_admin = isset($_POST['is_admin']) ? $_POST['is_admin'] : 0;
               
        
        $errors = [];
    
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
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        if (empty($errors)) {
            $result = $this->userModel->createUser($username, $hashed_password, $email, $imagespath, $room_id, $ext_attr, $total_amount_price, $is_admin);
    
            if ($result) {
                // User created successfully
                $response = array(
                    'status' => 'success',
                    'message' => 'User created successfully.'
                );
                
            } else {
                // Failed to create user
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to create user.'
                );
            }
        } else {
            // Errors found
            $response = array(
                'status' => 'error',
                'message' => $errors["img"]
            );
        }
    
        return json_encode($response);
    }

    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);
        require_once(__DIR__ . '/../views/user/edit.php');
    }

    public function update($id)
    {

// Start Validation of the Users Data
        $errors = [];
        $formvalues = [];


        $fields = ["username" => "Username", "email" => "Email", "password" => "Password", "confirm" => "Confirm password", "room_id" => "NO.ROOM", "ext_attr" => "NO.exit"];
        foreach ($fields as $field => $label) {
            if (empty($_POST[$field])) {
                $errors[$field] = "$label is Required";
            } else {
                $formvalues[$field] = $_POST[$field];
            }
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Email is Invalid";
        }

        if ($_POST["confirm"] != $_POST["password"]) {
            $errors["confirm"] = "Password isn't matched";
        }

        $formerrors = json_encode($errors);

        if ($errors) {

            ;

            $response = array(
                'status' => 'error',
                'message' => 'Failed to update user.',
                'formData' => $formerrors
            );

            return $response;
        }
        // End Validation of the Users Data

        if (!$errors) {

            $username = $_POST['username'];
            $useremail = $_POST['email'];
            $password = $_POST['password'];
            $userroom = $_POST['room_id'];
            $userext = $_POST['ext_attr'];
            $is_admin = isset($_POST['is_admin']) ? $_POST['is_admin'] : 0;

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $result = $this->userModel->updateUser($id, $username, $hashed_password, $useremail, $userroom, $userext,$is_admin);




        }


//        $username = $_POST['username'];
//        $password = $_POST['password'];
//        $email = $_POST['email'];
//        $image = $_POST['image'];
//        $room_id = $_POST['room_id'];
//        $ext_attr = $_POST['ext_attr'];
//        $total_amount_price = $_POST['total_amount_price'];
//        $is_admin = $_POST['is_admin'];


        if (isset($result) && $result) {
            // User updated successfully
            $response = array(
                'status' => 'success',
                'message' => 'User updated successfully.'
            );
        } else {
            // Failed to update user
            $response = array(
                'status' => 'error',
                'message' => 'Failed to update user.'
            );
        }
        return $response;
    }

    public function delete($id)
    {
        $result = $this->userModel->deleteUser($id);
        if ($result) {
            // User deleted successfully
            $response = array(
                'status' => 'success',
                'message' => 'User deleted successfully.'
            );
            header("Location:displayUsers.php");
        } else {
            // Failed to delete user
            $response = array(
                'status' => 'error',
                'message' => 'Failed to delete user.'
            );
        }
        return json_encode($response);
    }

    public function ForgetPassword($email)
    {
        return $this->userModel->getUserByEmail($email);
    }

    public function UpdatePassword($email, $password)
    {
        $result = $this->userModel->updateUserPassword($email, $password);
        if ($result) {
            // User updated successfully
            $response = array(
                'status' => 'success',
                'message' => 'User updated successfully.'
            );
        } else {
            // Failed to update user
            $response = array(
                'status' => 'error',
                'message' => 'Failed to update user.'
            );
        }
        return $response;
    }


    public function login()
    {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if(empty($email)){
            $response = array(
                'status' => 'error',
                'message' => 'Failed to login user.',
                'input' => 'Email',
                'error' => 'Email field is required'
            );
            return $response;
        }

        $row = $this->userModel->getUserByEmail($email);

        if ($row !== false && password_verify($password, $row["password"]) && $row["is_admin"] == 0) {
            session_start();
            $_SESSION["email"] = $email;
            $response = array(
                'status' => 'success',
                'message' => 'User logged successfully.',
                'admin' => 'false'
            );
            header("Location: user/userPage.php");
        } elseif ($row !== false && password_verify($password, $row["password"]) && $row["is_admin"] == 1) {
            session_start();
            $_SESSION["email"] = $email;
            $response = array(
                'status' => 'success',
                'message' => 'User logged successfully.',
                'admin' => 'true'
            );
        } else {
            if ($row === false) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to login user.',
                    'input' => 'Email',
                    'error' => 'This Email does not exist'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to login user.',
                    'input' => 'Password',
                    'error' => 'Incorrect password'
                );
            }
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Failed to login user.',
            'input' => 'All',
            'error' => 'Email or password not set'
        );
    }
    return $response;
}
}







