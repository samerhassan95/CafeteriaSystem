<?php
// controllers/user_controller.php

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/models/user_model.php');

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/config/database.php"));
    }

    public function index()
    {
        return $this->userModel->getAllUsers();
    }

    public function getUserByID($id)
    {
        return $this->userModel->getUserById($id);
    }

    public function getUsers()
    {
        return $this->userModel->getUsers();
    }

    public function getAdminUsers()
    {
        return $this->userModel->getAdminUsers();
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
        $room_id = $_POST['room_id'];
        $ext_attr = $_POST['ext_attr'];
        $total_amount_price = 0;
        $is_admin = isset($_POST['is_admin']) ? $_POST['is_admin'] : 0;


        $imageName = `userPlaceHolder.jpg`;

        if (isset($_FILES["img"]) && !empty($_FILES["img"]["name"])) {
            $file_name = $_FILES["img"]["name"];
            $file_tmp = $_FILES["img"]["tmp_name"];
            $allowed_extension = ["png", "jpg", "jpeg"];
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $id = time();

            if (in_array($extension, $allowed_extension)) {
                $imageName = explode('.', $file_name)[0] . "$id.$extension";
                $imagespath = $_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/public/images/users/{$imageName}";
                $uploaded = move_uploaded_file($file_tmp, $imagespath);
            } else {
                $errors["img"] = "Invalid image extension, allowed extensions are png, jpg and jpeg";
            }
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $result = $this->userModel->createUser($username, $hashed_password, $email, $imageName, $room_id, $ext_attr, $total_amount_price, $is_admin);

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


        return json_encode($response);
    }

    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);
        require_once(__DIR__ . '/../views/user/edit.php');
    }

    public function update($id)
    {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $room_id = $_POST['room_id'];
        $ext_attr = $_POST['ext_attr'];
        $total_amount_price = 0;
        $is_admin = isset($_POST['is_admin']) ? $_POST['is_admin'] : 0;


        $imageName = `userPlaceHolder.jpg`;

        if (isset($_FILES["img"]) && !empty($_FILES["img"]["name"])) {
            $file_name = $_FILES["img"]["name"];
            $file_tmp = $_FILES["img"]["tmp_name"];
            $allowed_extension = ["png", "jpg", "jpeg"];
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $Nameid = time();

            if (in_array($extension, $allowed_extension)) {
                $imageName = explode('.', $file_name)[0] . "$Nameid.$extension";
                $imagespath = $_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/public/images/users/{$imageName}";
                $uploaded = move_uploaded_file($file_tmp, $imagespath);
            } else {
                $errors["img"] = "Invalid image extension, allowed extensions are png, jpg and jpeg";
            }
        }


        $userData = $this->getUserByID($id);

        if ($password != $userData['password']) {

            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        $result = $this->userModel->updateUser($id,$username, $password, $email, $imageName, $room_id, $ext_attr, $total_amount_price, $is_admin);

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


        return json_encode($response);

    }

    public function updateUserTotalAmount($id,$price)
    {

        $userData = $this->getUserByID($id);

        $final_price = $userData['total_amount_price'] + $price;

        $result = $this->userModel->updateUserTotalAmount($id,$final_price);



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


        return json_encode($response);

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

            if (empty($email) && empty($password)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to login user.',
                    'input' => 'both',
                    'error' => 'fields are required'
                );
                return $response;
            } else if (empty($email)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to login user.',
                    'input' => 'Email',
                    'error' => 'Email field is required'
                );
                return $response;
            } else if (empty($password)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to login user.',
                    'input' => 'Password',
                    'error' => 'Password field is required'
                );
                return $response;
            }


            $row = $this->userModel->getUserByEmail($email);

            if ($row !== false && password_verify($password, $row["password"]) && $row["is_admin"] == 0) {
                session_start();
                $_SESSION["id"] = $row['id'];
                $response = array(
                    'status' => 'success',
                    'message' => 'User logged successfully.',
                    'admin' => 'false'
                );
                header("Location: user/userPage.php");
            } elseif ($row !== false && password_verify($password, $row["password"]) && $row["is_admin"] == 1) {
                session_start();
                $_SESSION["id"] = $row['id'];
//                $_SESSION["name"] = $row['username'];
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







