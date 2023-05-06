<?php
// models/order_model.php

class OrderModel
{
    private $conn;

    public function __construct(PDO $database)
    {
        $this->conn = $database;
    }

    public function createOrder($user_id, $room_id, $status, $total_price, $notes, $order_items)
    {
        try {
            $this->conn->beginTransaction();

            // Insert the new order into the Orders table
            $stmt = $this->conn->prepare('INSERT INTO orders(user_id, room_id, status, total_price, notes) VALUES(:user_id, :room_id, :status, :total_price, :notes)');
            $stmt->execute(array(
                ':user_id' => $user_id,
                ':room_id' => $room_id,
                ':status' => $status,
                ':total_price' => $total_price,
                ':notes' => $notes
            ));
            $order_id = $this->conn->lastInsertId();

            // Insert the order items into the Order Items table
            foreach ($order_items as $order_item) {
                $stmt = $this->conn->prepare('INSERT INTO `order_items`(order_id, product_id, quantity) VALUES(:order_id, :product_id, :quantity)');
                $stmt->execute(array(
                    ':order_id' => $order_id,
                    ':product_id' => $order_item['id'],
                    ':quantity' => $order_item['quantity']
                ));
            }

            $this->conn->commit();
            return $order_id;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function getOrderById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM Orders WHERE id = :id');
        $stmt->execute(array(':id' => $id));
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get the order items for the order
        $stmt = $this->conn->prepare('SELECT * FROM `Order Items` WHERE order_id = :order_id');
        $stmt->execute(array(':order_id' => $id));
        $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $order['order_items'] = $order_items;
        return $order;
    }

    // Define other methods for interacting with the Orders and Order Items tables here
}
