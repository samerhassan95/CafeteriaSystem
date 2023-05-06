<?php
// controllers/order_controller.php
require_once(__DIR__ . '/../models/order_model.php');

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel(require(__DIR__ . '/../config/database.php'));
    }

    public function createOrder($user_id, $room_id, $status, $total_price, $notes, $order_items)
    {
        $order_id = $this->orderModel->createOrder($user_id, $room_id, $status, $total_price, $notes, $order_items);
        if ($order_id) {
            // Order created successfully
            $response = array(
                'status' => 'success',
                'message' => 'Order created successfully.',
                'order_id' => $order_id
            );
        } else {
            // Failed to create order
            $response = array(
                'status' => 'error',
                'message' => 'Failed to create order.'
            );
        }
        return json_encode($response);
    }

    public function getOrderById($id)
    {
        $order = $this->orderModel->getOrderById($id);
        if ($order) {
            // Order found
            $response = array(
                'status' => 'success',
                'order' => $order
            );
        } else {
            // Order not found
            $response = array(
                'status' => 'error',
                'message' => 'Order not found.'
            );
        }
        return json_encode($response);
    }

    // Define other methods for handling orders here
}
