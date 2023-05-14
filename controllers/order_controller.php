<?php
// controllers/order_controller.php
include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/models/order_model.php");

//include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controller/user_controller.php");




class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel(include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/config/database.php"));
    }

    public function index()
    {
        // Fetch a list of all orders from the database
        return $this->orderModel->getAllOrders();

        //        // Display the list of orders
        //        foreach ($orders as $order) {
        //            echo "<p>Order ID: " . $order['id'] . ", User ID: " . $order['user_id'] . ", Room ID: " . $order['room_id'] . ", Start Date: " . $order['start_date'] . ", End Date: " . $order['end_date'] . ", Amount Price: " . $order['amount_price'] . "</p>";
        //        }
    }

    public function show($id)
    {
        // Fetch details for a specific order from the database
        $order = $this->orderModel->getOrderById($id);

        // If the order exists, display its details
        if ($order) {
            echo "<h1>Order " . $order['id'] . "</h1>";
            echo "<p>User ID: " . $order['user_id'] . "</p>";
            echo "<p>Room ID: " . $order['room_id'] . "</p>";
            echo "<p>Start Date: " . $order['start_date'] . "</p>";
            echo "<p>End Date: " . $order['end_date'] . "</p>";
            echo "<p>Amount Price: " . $order['amount_price'] . "</p>";
        } else {
            echo "<p>Order not found</p>";
        }
    }

    public function createOrder($user_id, $room_id, $status, $total_price, $notes, $order_items)
    {
        $order_id = $this->orderModel->createOrder($user_id, $room_id, $status, $total_price, $notes, $order_items);
        if ($order_id) {
            include "user_controller.php";
            $user_controller = new UserController();
            $user_controller->updateUserTotalAmount($user_id,$total_price);
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

    public function getLastOrder($id)
    {
        $order = $this->orderModel->getLastOrder($id);
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

    public function getCurrentOrder()
    {
        $order = $this->orderModel->getCurrentOrder();
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

    public function updateOrderState($id,$status)
    {
        $order = $this->orderModel->updateOrderState($id,$status);
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

    public function edit($id)
    {
        // Fetch details for a specific order from the database
        $order = $this->orderModel->getOrderById($id);

        // If the order exists, display a form to edit it
        if ($order) {
            echo "<form method='post'>";
            echo "<label>User ID:</label><input type='text' name='user_id' value='" . $order['user_id'] . "'>";
            echo "<label>Room ID:</label><input type='text' name='room_id' value='" . $order['room_id'] . "'>";
            echo "<label>Start Date:</label><input type='text' name='start_date' value='" . $order['start_date'] . "'>";
            echo "<label>End Date:</label><input type='text' name='end_date' value='" . $order['end_date'] . "'>";
            echo "<label>Amount Price:</label><input type='text' name='amount_price' value='" . $order['amount_price'] . "'>";
            echo "<input type='submit' value='Save'>";
            echo "</form>";

            // If the form has been submitted, update the order
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $user_id = $_POST['user_id'];
                $room_id = $_POST['room_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $amount_price = $_POST['amount_price'];
                $this->orderModel->updateOrder($id, $user_id, $room_id, $start_date, $end_date, $amount_price);
                header("Location: /index.php");
                exit;
            }
        } else {
            echo "<p>Order not found</p>";
        }
    }

    public function delete($id)
    {
        // Delete the specified order from the database
        $deletedOrder = $this->orderModel->deleteOrder($id);
        return $this->orderModel->getAllOrders();
        header("Location: /index.php");
        exit;
    }

    // Define other methods for handling orders here
}
