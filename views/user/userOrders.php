<?php
// Include the OrderModel and OrderController classes
include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/views/layouts/userNavbar.php");

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/order_controller.php");

// Create an instance of the OrderController class
$orderController = new OrderController();

// Get all orders from the database
$orders = $orderController->index();

//include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/user_controller.php");

$UserController = new UserController();
$user = $UserController->getUserByID($_SESSION['id']);


include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/product_controller.php');
$productController = new ProductController();

//var_dump($users);


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
    <h1 class="text-center bg-white border border-5 rounded-2 text-dark py-3 fw-bold"> Checks</h1>

    <div class="row">
        <div class="col">
            <label for="date" class="col-form-label">Date From</label>


            <input type="date" class="form-control" id="DateFrom" name="DateFrom"/>


        </div>

        <div class="col">
            <label for="date" class="col-form-label">Date to</label>


            <input type="date" class="form-control" name="DateTo" id="DateTo"/>


        </div>
    </div>

    <table class="table table-hover" style="text-align: center; cursor: pointer" onclick
    "showOrders()">
    <thead>
    <tr>

        <th scope="col">Name</th>
        <th scope="col">Total Amount</th>
    </tr>
    </thead>
    <tbody>
        <tr class="userTable" data-user-id="<?= $user['id'] ?>">

            <td scope="col"><?= $user['username'] ?></td>
            <td scope="col"><?= $user['total_amount_price'] ?></td>

        </tr>


        <?php foreach ($orders as $order):
            if ($order["user_id"] == $user['id']) {


                echo "<tr class = 'orderTable' data-user-id='{$user["id"]}' >";
                echo '<td colspan="2">';
                echo '<table class="table table-dark">';
                echo '<thead>';

                echo '<tr>';
                echo '<th scope="col">Created at</th>';
                echo '<th scope="col">Total Price</th>';
                echo '</tr>';

                echo '</thead>';
                echo '<tbody>';

                echo "<tr class = 'orderItemsTable' data-order-id='{$order['id']}'>";
                echo "<td>{$order['created_at']}</td>";
                echo "<td>{$order['total_price']}</td>";
                echo '</tr>';

                $order_items = $order['order_items'];

                echo "<tr class = 'productsTable' data-order-id='{$order['id']}'> ";
                echo '<td colspan="2">';
                echo '<table class="table" style="background-color: #a98b7c">';
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

                echo '</tbody>';
                echo '</table>';
                echo '</td>';
                echo '</tr>';
            }


        endforeach; ?>


    </tbody>
    </table>
</div>

<script>
    const rows = document.querySelectorAll('table tr.userTable[data-user-id]');

    rows.forEach(row => {
        row.addEventListener('click', () => {
            const orderId = row.dataset.userId;
            const orderTables = document.querySelectorAll(`tr.orderTable[data-user-id="${orderId}"]`);


            orderTables.forEach(orderTable => {
                const orderItemsTables = orderTable.querySelectorAll('table tr.orderItemsTable[data-order-id]');
                if (orderTable.style.display === 'none') {
                    orderTable.style.display = 'table-row';
                    // orderItemsTables.forEach(table => table.style.display = 'table-row');
                } else {
                    orderTable.style.display = 'none';
                    // orderItemsTables.forEach(table => table.style.display = 'none');
                }
                orderItemsTables.forEach(tableItem => {
                    tableItem.addEventListener('click', () => {
                        const orderItemsId = tableItem.dataset.orderId;
                        const productsTable = document.querySelectorAll(`tr.productsTable[data-order-id="${orderItemsId}"]`);
                        productsTable.forEach(productTable => {
                            if (productTable.style.display === 'none') {
                                productTable.style.display = 'table-row';
                                // orderItemsTables.forEach(table => table.style.display = 'table-row');
                            } else {
                                productTable.style.display = 'none';
                                // orderItemsTables.forEach(table => table.style.display = 'none');
                            }
                        })

                        // const products = document.querySelectorAll(`.orderItemsTable[data-order-id="${orderItemsId}"]`);
                        // const product = table.querySelectorAll(`tr.orderTable[data-user-id="${orderId}"]`)[0].querySelectorAll(`.orderItemsTable[data-order-id="39"`)
                        // orderItemaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa

                        // if (table.style.display === 'none') {
                        //     table.style.display = 'table-row';
                        //     // orderItemsTables.forEach(table => table.style.display = 'table-row');
                        // } else {
                        //     table.style.display = 'none';
                        //     // orderItemsTables.forEach(table => table.style.display = 'none');
                        // }
                    });
                });
            })

        });
    });


    const DateFrom = document.getElementById('DateFrom');
    const DateTo = document.getElementById('DateTo');

    DateFrom.addEventListener('change', () => {

        const rows = document.querySelectorAll('table tr.userTable[data-user-id]');


        rows.forEach(row => {

            const orderId = row.dataset.userId;
            const orderTables = document.querySelectorAll(`tr.orderTable[data-user-id="${orderId}"]`);

            // console.log(orderTables);

            orderTables.forEach(orderTable => {
                const orderItemsTables = orderTable.querySelectorAll('table tr.orderItemsTable[data-order-id]');
                orderItemsTables.forEach(tableItem => {
                    // console.log(tableItem.childNodes[0].innerText.split(" ")[0]);

                    if (DateFrom.value !== "" && DateTo.value !== "") {
                        if (tableItem.childNodes[0].innerText.split(" ")[0] >= DateFrom.value && tableItem.childNodes[0].innerText.split(" ")[0] <= DateTo.value) {
                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'table-row';
                            // orderItemsTables.forEach(table => table.style.display = 'table-row');
                        } else {
                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'none';
                        }
                    } else if (DateFrom.value !== "") {
                        console.log("asdasdadasdasdas");
                        if (tableItem.childNodes[0].innerText.split(" ")[0] >= DateFrom.value) {
                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'table-row';
                            // orderItemsTables.forEach(table => table.style.display = 'table-row');
                        } else {
                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'none';
                            // orderItemsTables.forEach(table => table.style.display = 'none');
                        }
                    } else {
                        if (DateTo.value !== "") {
                            if (tableItem.childNodes[0].innerText.split(" ")[0] <= DateTo.value) {
                                tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'table-row';
                                // orderItemsTables.forEach(table => table.style.display = 'table-row');
                            } else {
                                tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'none';
                                // orderItemsTables.forEach(table => table.style.display = 'none');
                            }
                        } else {
                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'table-row';
                        }
                        // orderItemsTables.forEach(table => table.style.display = 'none');
                    }
                });
            });

        });
    });

    DateTo.addEventListener('change', () => {

        const selectedValue = DateFrom.value;
        console.log(selectedValue);


        const rows = document.querySelectorAll('table tr.userTable[data-user-id]');


        rows.forEach(row => {

            const orderId = row.dataset.userId;
            const orderTables = document.querySelectorAll(`tr.orderTable[data-user-id="${orderId}"]`);

            console.log(orderTables);

            orderTables.forEach(orderTable => {
                const orderItemsTables = orderTable.querySelectorAll('table tr.orderItemsTable[data-order-id]');
                orderItemsTables.forEach(tableItem => {
                    console.log("========================================");
                    console.log(DateFrom.value);
                    console.log(DateTo.value);
                    if (DateFrom.value !== "" && DateTo.value !== "") {
                        if (tableItem.childNodes[0].innerText.split(" ")[0] >= DateFrom.value && tableItem.childNodes[0].innerText.split(" ")[0] <= DateTo.value) {

                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'table-row';
                            // orderItemsTables.forEach(table => table.style.display = 'table-row');
                        } else {

                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'none';
                            // orderItemsTables.forEach(table => table.style.display = 'none');
                        }
                    } else if (DateTo.value !== "") {
                        if (tableItem.childNodes[0].innerText.split(" ")[0] <= DateTo.value) {

                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'table-row';
                            // orderItemsTables.forEach(table => table.style.display = 'table-row');
                        } else {
                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'none';
                            // orderItemsTables.forEach(table => table.style.display = 'none');
                        }
                    } else {
                        if (DateFrom.value !== "") {
                            if (tableItem.childNodes[0].innerText.split(" ")[0] >= DateFrom.value) {
                                tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'table-row';
                                // orderItemsTables.forEach(table => table.style.display = 'table-row');
                            } else {
                                tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'none';
                                // orderItemsTables.forEach(table => table.style.display = 'none');
                            }
                        } else {

                            tableItem.parentElement.parentElement.parentElement.parentElement.style.display = 'table-row';
                        }
                        // orderItemsTables.forEach(table => table.style.display = 'none');
                    }
                });
            });

        });
    });

</script>

</body>
</html>

