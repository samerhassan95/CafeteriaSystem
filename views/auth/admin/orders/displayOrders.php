<?php

// Include the OrderModel and OrderController classes
include($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/views/navbar.php");

include($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/controllers/order_controller.php");

// Create an instance of the OrderController class
$orderController = new OrderController();

// Get all orders from the database
$orders = $orderController->index();

include($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/controllers/user_controller.php");

$UserController = new UserController();
$users = $UserController->index();
//var_dump($users);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        /* Style for the order items table */
        #order-items-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Users</h2>

    <!-- Table of all users -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($users as $user): ?>
            <tr class="clickable user-row" data-user-id="<?= $user['id'] ?>">
                <td><?= $user['id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

    <h2>Orders</h2>

    <!-- Table of all orders -->
    <table class="table table-striped" id="orders-table">
        <thead>
        <tr>
            <th>Created at</th>
            <th>Total Price</th>
            <th>Room ID</th>
            <th>Notes</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($orders as $order): ?>
            <tr class="clickable order-row hidden" data-user-id="<?= $order['user_id'] ?>">
                <td><?= $order['created_at'] ?></td>
                <td><?= $order['total_price'] ?></td>
                <td><?= $order['room_id'] ?></td>
                <td><?= $order['notes'] ?></td>
                <td><?= $order['status'] ?></td>
            </tr>
            <tr class="hidden-row hidden" data-user-id="<?= $order['user_id'] ?>">
                <td colspan="6">
                    <!-- Table of order items for this order -->
                    <table class="table table-striped" id="order-items-table">
                        <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $order_items = $order['order_items']; ?>
                        <?php foreach ($order_items as $order_item): ?>
                            <tr>
                                <td><?= $order_item['product_id'] ?></td>
                                <td><?= $order_item['quantity'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>

<script>
    // Add click event listener to all user rows
    var userRows = document.querySelectorAll('.user-row');
    userRows.forEach(function(userRow) {
        userRow.addEventListener('click', function(event) {
            // Get the user ID from the data-user-id attribute
            var userId = userRow.getAttribute('data-user-id');
            // Find all order rows with the same user ID and show them
            var orderRows = document.querySelectorAll('.order-row[data-user-id="' + userId + '"]');
            orderRows.forEach(function(orderRow) {
                orderRow.classList.remove('hidden');
            });
        });
    });

    // Add click event listener to all order rows
    var orderRows = document.querySelectorAll('.order-row');
    orderRows.forEach(function(orderRow) {
        orderRow.addEventListener('click', function(event) {
            // Find the hidden row with the same order ID
            var hiddenRow = orderRow.nextElementSibling;
            // Toggle the hidden row's visibility
            hiddenRow.classList.toggle('hidden');
        });
    });
</script>

</body>
</html>