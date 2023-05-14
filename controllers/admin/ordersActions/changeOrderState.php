<?php
include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/order_controller.php");

// Create an instance of the OrderController class
$orderController = new OrderController();

// Get all orders from the database

$result = json_decode($orderController->updateOrderState($_GET['id'],'Done'), true);

header('Location: /CafeteriaSystem/views/admin/orders/displayCurrentOrders.php');
exit();

