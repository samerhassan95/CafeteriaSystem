<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location:/CafeteriaSystem/views/auth/login.php");
    exit;
}

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/user_controller.php");


$UserController = new UserController();
$userData = $UserController->getUserByID($_SESSION["id"]);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!--        <link rel="stylesheet" href="http://localhost/CafeteriaSystem/public/styles/navbar.css">-->


    <title>Document</title>


    <style>
        .logout-btn {
            background-color: #212529;
            border-color: #e59285;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease-in-out;
            margin-left: 6%;
        }
        .logout-btn:hover {
            background-color: #c05d4c;
            border-color: #c05d4c;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: white;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #e59285;
        }

    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <div style="background-color:white; padding: 3px; border-radius: 10%">
                <img src="/CafeteriaSystem/public/images/logo2.png" alt="Logo" class="d-inline-block align-text-top"
                     style="width: 4em">

            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active fs-5" aria-current="page" href="/CafeteriaSystem/views/admin/adminPage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/CafeteriaSystem/views/admin/products/allProducts.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5"
                       href="/CafeteriaSystem/views/admin/categories/allcategories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/CafeteriaSystem/views/admin/users/displayUsers.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/CafeteriaSystem/views/admin/orders/displayOrders.php"">Checks</a>
                </li>
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link fs-5" href="/CafeteriaSystem/views/admin/orders/displayCurrentOrders.php">Orders</a>-->
<!--                </li>-->
            </ul>
            <div class="d-flex navbar-nav dropdown rounded ms-auto me-4">
                <div>
                    <a class="me-2 mb-3 text-decoration-none d-flex justify-content-center align-items-center gap-2 h-100 text-light" href="#">
                        <i class="fa fa-user"></i>
                        <?php echo $userData['username']; ?>
                    </a>
                </div>
                <a href="/CafeteriaSystem/views/auth/logout.php" class="logout btn btn-primary logout-btn">Logout</a>
            </div>
        </div>

    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>