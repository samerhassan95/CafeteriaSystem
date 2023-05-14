<?php
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/views/layouts/navbar.php');
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/category_controller.php');
$categoryController = new CategoryController();
$categories = $categoryController->index();
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
    <h1 class="text-center bg-white border border-5 rounded-2 text-dark py-3 fw-bold"> Categories</h1>
    <a type="button" class="btn btn-success m-2" href="addCategory.php">Add Category</a>

    <table class="table table-hover rounded text-center">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($categories as $row) {
            echo "<tr>";
            echo "<td> {$row['id']}</td>";
            echo "<td> {$row['name']}</td>";
            echo "<td> <a type='button' class='btn btn-warning' href='editCategory.php?id={$row['id']}'>Edit</a></td>";
            echo "<td> <a type='button' class='btn btn-danger' href='/CafeteriaSystem/controllers/admin/categoryActions/deleteCategory.php?id={$row['id']}'> Delete</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>