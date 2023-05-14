<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';

// $db = require_once('../../config/database.php');

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/views/layouts/navbar.php");

//include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/user_controller.php");
//
$UserController = new UserController();
$users = $UserController->index();

//var_dump($users);
//exit();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Users</title>
</head>
<style>
    body {
        background-image: url(/cafeteriaSystem/public/images/background.jpg);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>

<body>
<div class="table-responsive container mt-5 rounded w-75" style="background-color:   #cfcfcfb8">
    <h1 class="text-center bg-white border border-5 rounded-2 text-dark py-3 fw-bold"> Cafeteria Users Accounts</h1>
    <a type="button" class="btn btn-success m-2" href="addUser.php">Add User</a>

    <table class="table table-hover rounded text-center">
        <thead>
        <tr>
            <th>#</th>
            <th>username</th>
            <th>email</th>
            <th>Image</th>
            <th>Room No</th>
            <th>Ext</th>
            <th>Edit</th>
            <th>Delete</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <th><?= $user['id'] ?></th>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>

                <td><img style='width: 4em; height: 3em'
                         src='/CafeteriaSystem/public/images/users/<?= $user['image'] ?>'</td>

                <td><?= $user['room_id'] ?></td>
                <td><?= $user['ext_attr'] ?></td>

                <td>
                    <a href="editUser.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edit</a>

                </td>
                <td>
                    <a href="deleteUser.php?id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>