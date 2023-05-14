<?php

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/views/layouts/userNavbar.php');

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/product_controller.php');

$productController = new ProductController();
$products = $productController->getAllProducts();

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/order_controller.php');
$orderController = new OrderController();
$order = json_decode($orderController->getLastOrder($_SESSION["id"]), true);

$lastOrderProducts = [];
foreach ($order['order']['order_items'] as $item) {
    $productDetails = $productController->getProductById($item['product_id']);
    array_push($lastOrderProducts, $productDetails);
}

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/room_controller.php");
$roomController = new RoomController();
$rooms = $roomController->index();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!--    <link rel="stylesheet" href="register.css">-->
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


<div class="container my-3 h-100" id="home" data-user-id="<?php echo $_SESSION["id"] ?>">
    <div class="row h-100 px-2">
        <div style="min-height: 30em;
        background: rgba( 255, 255, 255, 0.45 );
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 6px );
-webkit-backdrop-filter: blur( 6px );
border: 1px solid rgba( 255, 255, 255, 0.18 );
" class="col-12 col-md-4 d-flex flex-column justify-content-between border border-1 rounded-start border-dark">
            <div id="order" class="mt-3 d-flex flex-column align-items-center flex-grow-1 overflow-auto">

            </div>

            <div class="mt-1 d-flex flex-column justify-content-around flex-shrink-0 h-50">

                <label>Notes:</label>
                <textarea class="w-100" id="note"></textarea>

                <div class="d-flex align-items-center">
                    <p style="margin: 0;" class="me-3">Room</p>
                    <select class="form-select" name="room_id" id="roomOption">
                        <option value="0">Select Room Number</option>
                        <?php
                        foreach ($rooms as $room) {
                            echo "<option value='{$room["id"]}' id='{$room['id']}'>{$room['name']}</option>";
                        }
                        ?>
                    </select>

                </div>

                <div class="w-100 bg-dark" style="height: 2px;"></div>

                <div class="d-flex w-100 align-items-center justify-content-between">
                    <p>Total</p>
                    <p id="totalPrice">0 EGP</p>
                </div>

                <button class="btn btn-warning w-100" onclick="sendOrder()">Done</button>
            </div>

        </div>


        <div class="col-12 col-md-8 rounded-end" style="height: 82vh; overflow:auto;background-color: #e1e1e1;">

            <h2>Latest order</h2>
            <div class="d-flex gap-5 flex-wrap">
                <?php foreach ($lastOrderProducts as $product) : ?>
                    <div class="card" id="<?= $product['id'] ?>" style="width: 10rem; cursor:pointer"
                         onclick="AddToOrder(this)">
                        <img src="/CafeteriaSystem/public/images/products/<?= $product['image'] ?>"
                             alt="<?= $product['name'] ?>" class="card-img-top">
                        <div class=" card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <h5 class="card-price"><?= $product['price'] ?> EGP</h5>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="w-100 bg-dark my-5" style="height: 2px;"></div>


            <div class="row d-flex flex-wrap gap-5 mx-auto">
                <?php foreach ($products as $index => $product) : ?>
                    <div class="card" id="<?= $product['id'] ?>" style="width: 10rem; cursor:pointer"
                         onclick="AddToOrder(this)">
                        <img src="/CafeteriaSystem/public/images/products/<?= $product['image'] ?>"
                             alt="<?= $product['name'] ?>" class="card-img-top h-50" style="object-fit: cover">
                        <div class=" card-body h-50">
                            <h5 class="card-title fs-6"><?= $product['name'] ?></h5>
                            <h5 class="card-price fs-6"><?= $product['price'] ?> EGP</h5>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </div>
</div>


<script>
    var showOrder = true;
    var orderList = [];
    var finalPrice = 0;

    function changeTotalPrice() {
        finalPrice = 0;
        orderList.forEach((item) => (finalPrice += item.totalPrice));
        document.getElementById("totalPrice").innerText =
            finalPrice.toFixed(2) + " EGP";
    }

    function AddToOrder(product) {
        const title = product.querySelector(".card-title").textContent;
        const price = product.querySelector(".card-price").textContent;

        if (!orderList.some((Item) => Item.id == product.id)) {
            orderList.push({
                productName: title,
                id: product.id,
                quantity: 1,
                productPrice: parseFloat(price),
                totalPrice: parseFloat(price),
            });

            var orderDiv = document.getElementById("order");
            orderDiv.innerHTML += `<div id= "${product.id}" class="d-flex align-items-center align-content-center mb-3">
        <h5 style="width: 5em;">${title}</h5>
        <div class="d-flex align-items-center align-content-center mx-3">
          <button class="btn btn-danger px-3 minus-btn" onclick="decrement(this)">-</button>
          <h4 class="mx-3 mt-1 quantity">1</h4>
          <button class="btn btn-success px-3 plus-btn" onclick="Increment(this)">+</button>
        </div>
        <h5 class="price">${price}</h5>
      </div>`;
        }

        changeTotalPrice();
    }

    function Increment(element) {
        var product = orderList.find(
            (Item) => Item.id == element.parentNode.parentNode.id
        );
        if (product) {
            product.quantity = product.quantity + 1;
            product.totalPrice = product.productPrice * product.quantity;
            element.previousElementSibling.innerText = product.quantity;
            element.parentNode.nextElementSibling.innerText =
                product.totalPrice.toFixed(2) + " EGP";
        }

        changeTotalPrice();
    }

    function decrement(element) {
        var product = orderList.find(
            (Item) => Item.id == element.parentNode.parentNode.id
        );

        if (product) {
            if (product.quantity > 1) {
                product.quantity = product.quantity - 1;
                product.totalPrice = product.productPrice * product.quantity;
                console.log(product.quantity);
                element.nextElementSibling.innerText = product.quantity;
                element.parentNode.nextElementSibling.innerText =
                    product.totalPrice.toFixed(2) + " EGP";
            } else if (product.quantity == 1) {
                element.parentNode.parentNode.remove();
                orderList.splice(
                    orderList.findIndex((item) => item.id == product.id),
                    1
                );
                console.log(orderList);
            }
        }

        changeTotalPrice();
    }

    function sendOrder() {
        var selectionElement = document.getElementById("roomOption");
        var selectionValue = selectionElement.value;

        var notesElement = document.getElementById("note").value;

        var orderDetails = {
            user_id: document.getElementById('home').getAttribute('data-user-id'),
            room_id: selectionValue,
            status: "processing",
            total_price: finalPrice,
            notes: notesElement,
            order_items: orderList,
        };

        // console.log(JSON.stringify(orderDetails));
        fetch("http://localhost/CafeteriaSystem/controllers/store_order.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(orderDetails),
        })
            .then((response) => response.json())
            .then((data) => {
                alert('Order added sucessfully')
            })
            .catch((error) => {
                alert('Error, try again')
            });
    }
</script>
</body>

</html>