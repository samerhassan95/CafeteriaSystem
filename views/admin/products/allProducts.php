<?php
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/views/layouts/navbar.php');
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/product_controller.php');
$productController = new ProductController();
$products = $productController->getAllProducts();

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/category_controller.php");
$category_controller = new CategoryController();

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
    <h1 class="text-center bg-white border border-5 rounded-2 text-dark py-3 fw-bold"> Cafeteria Products</h1>
    <a type="button" class="btn btn-success m-2" href="addProduct.php">Add Product</a>

    <table class="table table-hover rounded text-center">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>
            <th scope="col">Category</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($products as $index => $row) {
            $category = $category_controller->show($row['category_id']);
            echo "<tr>";
            echo "<td>" . ($index + 1) . "</td>";
            echo "<td> {$row['name']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td><img style='width: 4em; height: 3em' src='/CafeteriaSystem/public/images/products/" . $row['image'] . "'></td>";
            echo "<td>" . $category['name'] . "</td>";
            echo "<td> <a type='button' class='btn btn-warning' href='editProduct.php?id={$row['id']}'>Edit</a></td>";
            echo "<td> <a type='button' class='btn btn-danger' href='/CafeteriaSystem/controllers/admin/productActions/deleteProduct.php?id={$row['id']}'> Delete</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>