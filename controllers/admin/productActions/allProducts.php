<?php
include '../../product_controller.php';
$productController = new ProductController();
$products = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>


<body>

<div class="table-responsive container mt-5 rounded">
    <a type="button" class="btn btn-success m-2" href="addProduct.php">Add Product</a>
    <table class="table table-light rounded text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
                foreach ($products as $row) {
                    echo "<tr>";
                    echo "<td> {$row['id']}</td>";
                    echo "<td> {$row['name']}</td>";
                    echo "<td>{$row['price']}</td>";
                    echo "<td><img src='../images/" . $row['image'] . "'></td>";
                    echo "<td> <a type='button' class='btn btn-warning' href='editProduct.php?id={$row['id']}'>Edit</a></td>";
                    echo "<td> <a type='button' class='btn btn-danger' href='deleteProduct.php?id={$row['id']}'> Delete</a></td>";
                    echo "</tr>";
                }
        ?>
        </tbody>
    </table>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>