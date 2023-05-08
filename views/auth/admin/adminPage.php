<?php

session_start();
include($_SERVER["DOCUMENT_ROOT"] . '/cafeITI/views/navbar.php');

if (!isset($_SESSION["email"])) {
    header("Location:../alertPage.php");
    exit;
}

include($_SERVER["DOCUMENT_ROOT"] . '/cafeITI/controllers/product_controller.php');

$productController = new ProductController();
$products = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>


    <!-- <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../public/img/logo.jpg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Bootstrap
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My orders</a>
                    </li>
                </ul>
                <form class="d-flex align-items-center" role="search">
                    <img src="../public/img/logo.jpg" alt="Logo" width="30" height="24">
                    <h6 style="margin: 0;" class="ms-3">Youssef Mohamed</h6>
                </form>
            </div>
        </div>
    </nav> -->



    <div class="container my-5">
        <div class="row">
            <div class="col-4 border border-2 border-dark">
                <div id="order">

                </div>

                <textarea class="mt-5 w-100" id="note"></textarea>

                <div class="d-flex align-items-center my-5">
                    <p style="margin: 0;" class="me-3">Room</p>
                    <select class="form-select" id="roomOption" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>

                <div class="w-100 bg-dark my-5" style="height: 2px;"></div>

                <div class="d-flex w-100 align-items-center justify-content-between px-3 my-5">
                    <p>Total</p>
                    <p id="totalPrice">0 EGP</p>
                </div>

                <button class="btn btn-warning w-100" onclick="sendOrder()">Done</button>

            </div>


            <div class="col-8" style="background-color: #e1e1e1;">
                <p>Latest order</p>
                <div class="d-flex gap-5 flex-wrap">
                    <div class="card" style="width: 10rem;">
                        <img src="../public/img/coffee2.png" alt="coffee" class="card-img-top">
                        <div class=" card-body">
                            <h5 class="card-title">Tea</h5>
                            <h5 class="card-title">13EGP</h5>
                        </div>
                    </div>
                    <div class="card" style="width: 10rem;">
                        <img src="../public/img/coffee2.png" alt="coffee" class="card-img-top">
                        <div class=" card-body">
                            <h5 class="card-title">Tea</h5>
                            <h5 class="card-title">13EGP</h5>
                        </div>
                    </div>
                    <div class="card" style="width: 10rem;">
                        <img src="../public/img/coffee2.png" alt="coffee" class="card-img-top">
                        <div class=" card-body">
                            <h5 class="card-title">Tea</h5>
                            <h5 class="card-title">13EGP</h5>
                        </div>
                    </div>
                    <div class="card" style="width: 10rem;">
                        <img src="../public/img/coffee2.png" alt="coffee" class="card-img-top">
                        <div class=" card-body">
                            <h5 class="card-title">Tea</h5>
                            <h5 class="card-title">13EGP</h5>
                        </div>
                    </div>
                    <div class="card" style="width: 10rem;">
                        <img src="../public/img/coffee2.png" alt="coffee" class="card-img-top">
                        <div class=" card-body">
                            <h5 class="card-title">Tea</h5>
                            <h5 class="card-title">13EGP</h5>
                        </div>
                    </div>
                </div>

                <div class="w-100 bg-dark my-5" style="height: 2px;"></div>



                <div class="d-flex gap-5 flex-wrap">
                    <?php foreach ($products as $product) : ?>
                        <div class="card" id="<?= $product['id'] ?>" style="width: 10rem; cursor:pointer" onclick="AddToOrder(this)">
                            <img src="../../../public/images/homepage/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="card-img-top">
                            <div class=" card-body">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <h5 class="card-price"><?= $product['price'] ?> EGP</h5>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
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
        <h5 style="width: 2em;">${title}</h5>
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
                user_id: 1,
                room_id: selectionValue,
                status: "processing",
                total_price: finalPrice,
                notes: notesElement,
                order_items: orderList,
            };

            // console.log(JSON.stringify(orderDetails));
            fetch("../../store_order.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(orderDetails),
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    </script>
</body>

</html>