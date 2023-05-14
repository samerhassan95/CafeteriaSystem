<?php

// Include the OrderModel and OrderController classes
include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/views/layouts/navbar.php");

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/order_controller.php");

// Create an instance of the OrderController class
$orderController = new OrderController();

// Get all orders from the database
$orders = json_decode($orderController->getCurrentOrder(), true);


//include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/user_controller.php");

$UserController = new UserController();


include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/product_controller.php');
$productController = new ProductController();

//var_dump($users);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
    <style>
        /* Style for the order items table */
        #order-items-table {
            margin-top: 20px;
        }

        .orderTable {
            display: none;
            /*visibility: visible;*/
        }

        /*.orderItemsTable{*/
        /*    visibility: collapse;*/
        /*    !*visibility: visible;*!*/
        /*}*/
    </style>
</head>
<body>

<div class="container">

    <h2>Orders</h2>


    <?php
    if ($orders['status'] != "error"){

    ?>
    <table class="table table-hover" style="text-align: center; cursor: pointer" onclick
    "showOrders()">
    <thead>
    <tr>

        <th scope="col">Order Date</th>
        <th scope="col">Name</th>
        <th scope="col">Room</th>
        <th scope="col">Ext</th>
        <th scope="col">Actions</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders['order'] as $order): ?>

        <?php $user = $UserController->getUserByID($order['user_id']) ?>

        <tr class="userTable" data-user-id="<?= $order['id'] ?>">

            <td scope="col"><?= $order['created_at'] ?></td>
            <td scope="col"><?= $user['username'] ?></td>
            <td scope="col"><?= $order['room_id'] ?></td>
            <td scope="col"><?= $user['ext_attr'] ?></td>
            <td scope="col"><a class="btn btn-success" href="/CafeteriaSystem/controllers/admin/ordersActions/changeOrderState.php?id=<?php echo $order['id']; ?>">deliver</a></td>

        </tr>


        <?php

        $order_items = $order['order_items'];

        echo "<tr class = 'orderTable' data-user-id='{$order["id"]}'> ";
        echo '<td colspan="5">';
        echo '<table class="table bg-danger" >';
        echo '<thead>';

        echo '<tr>';
        echo '<th scope="col">id</th>';
        echo '<th scope="col">Product Name</th>';
        echo '<th scope="col">Quantity</th>';
        echo '<th scope="col">Total Price</th>';
        echo '</tr>';

        echo '</thead>';
        echo '<tbody>';
        foreach ($order_items as $order_item):
            $product = $productController->getProductById($order_item['product_id']);


            echo "</tr>";
            echo "<td>{$order_item['product_id']}</td>";
            echo "<td>{$product['name']}</td>";
            echo "<td>{$order_item['quantity']}</td>";
            $totalPrice = $product['price'] * $order_item['quantity'];
            echo "<td>{$totalPrice}</td>";
            echo "</tr>";


        endforeach;

        echo '</tbody>';
        echo '</table>';
        echo '</td>';
        echo '</tr>';

        ?>
    <?php endforeach; ?>


    </tbody>
    </table>

    <?php
    }

    else{

        echo '<h1>There is no current orders</h1>';
    }

    ?>

</div>

<script>
    const rows = document.querySelectorAll('table tr.userTable[data-user-id]');

    rows.forEach(row => {
        row.addEventListener('click', () => {
            const orderId = row.dataset.userId;
            const orderTable = document.querySelector(`tr.orderTable[data-user-id="${orderId}"]`);




                if (orderTable.style.display === 'table-row') {
                    orderTable.style.display = 'none';
                    // orderItemsTables.forEach(table => table.style.display = 'table-row');
                } else {
                    orderTable.style.display = 'table-row';
                    // orderItemsTables.forEach(table => table.style.display = 'none');
                }


        });
    });

</script>

</body>
</html>

