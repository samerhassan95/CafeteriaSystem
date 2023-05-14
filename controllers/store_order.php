<?php
// store_order.php
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/order_controller.php');

// Get the JSON data from the POST request
$order_data = json_decode(file_get_contents('php://input'), true);

// Create a new OrderController instance
$order_controller = new OrderController();


// header('Content-Type: application/json');
// echo json_encode($order_data);
// Call the createOrder method with the order data
$response = $order_controller->createOrder($order_data['user_id'], $order_data['room_id'], $order_data['status'], $order_data['total_price'], $order_data['notes'], $order_data['order_items']);

// Send the response as JSON
header('Content-Type: application/json');
//echo json_encode($response);
echo json_encode($response);
