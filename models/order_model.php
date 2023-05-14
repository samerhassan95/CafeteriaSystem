<?php
// models/order_model.php

class OrderModel
{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getAllOrders()
    {
        $stmt = $this->db->prepare('SELECT * FROM orders ORDER BY created_at DESC');
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as &$order) {
            $stmt = $this->db->prepare('SELECT * FROM `order_items` WHERE order_id = :order_id');
            $stmt->execute(array(':order_id' => $order['id']));
            $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $order['order_items'] = $order_items;
//            var_dump($order);
        }


        return $orders;
    }

    public function getOrderById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM Orders WHERE id = :id');
        $stmt->execute(array(':id' => $id));
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get the order items for the order
        $stmt = $this->db->prepare('SELECT * FROM `order_items` WHERE order_id = :order_id');
        $stmt->execute(array(':order_id' => $id));
        $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $order['order_items'] = $order_items;
        return $order;
    }

    public function getLastOrder($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM Orders WHERE user_id = :id order by id DESC limit 1');
        $stmt->execute(array(':id' => $id));
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get the order items for the order
        $stmt = $this->db->prepare('SELECT * FROM `order_items` WHERE order_id = :order_id');
        $stmt->execute(array(':order_id' => $order['id']));
        $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $order['order_items'] = $order_items;
        return $order;
    }

    public function getCurrentOrder()
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE status like "processing" order by id DESC');
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as &$order) {
            $stmt = $this->db->prepare('SELECT * FROM `order_items` WHERE order_id = :order_id');
            $stmt->execute(array(':order_id' => $order['id']));
            $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $order['order_items'] = $order_items;
//            var_dump($order);
        }

        return $orders;
    }


    public function createOrder($user_id, $room_id, $status, $total_price, $notes, $order_items)
    {
        try {
            $this->db->beginTransaction();

            // Insert the new order into the Orders table
            $stmt = $this->db->prepare('INSERT INTO orders(user_id, room_id, status, total_price, notes) VALUES(:user_id, :room_id, :status, :total_price, :notes)');
            $stmt->execute(array(
                ':user_id' => $user_id,
                ':room_id' => $room_id,
                ':status' => $status,
                ':total_price' => $total_price,
                ':notes' => $notes
            ));
            $order_id = $this->db->lastInsertId();

            // Insert the order items into the Order Items table
            foreach ($order_items as $order_item) {
                $stmt = $this->db->prepare('INSERT INTO `order_items`(order_id, product_id, quantity) VALUES(:order_id, :product_id, :quantity)');
                $stmt->execute(array(
                    ':order_id' => $order_id,
                    ':product_id' => $order_item['id'],
                    ':quantity' => $order_item['quantity']
                ));
            }

            $this->db->commit();
            return $order_id;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }


    public function updateOrder($id, $user_id, $room_id, $start_date, $end_date, $amount_price)
    {
        $stmt = $this->db->prepare('UPDATE orders SET user_id = ?, room_id = ?, start_date = ?, end_date = ?, amount_price = ?, updated_at = NOW() WHERE id = ?');
        return $stmt->execute([$user_id, $room_id, $start_date, $end_date, $amount_price, $id]);
    }

    public function updateOrderState($id,$status)
    {
        $stmt = $this->db->prepare('UPDATE orders SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }

    public function deleteOrder($id)
    {
        $stmt = $this->db->prepare('DELETE FROM orders WHERE id = ?');
        return $stmt->execute([$id]);
    }


    // Define other methods for interacting with the Orders and Order Items tables here
}
