<?php
// models/user_model.php

class UserModel
{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare('SELECT * FROM users');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsers()
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE is_admin = 0');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdminUsers()
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE is_admin = 1');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $password, $email, $image, $room_id, $ext_attr, $total_amount_price, $is_admin)
    {
        $stmt = $this->db->prepare('INSERT INTO users (username, password, email, image, room_id, ext_attr, total_amount_price, is_admin, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        return $stmt->execute([$username, $password, $email, $image, $room_id, $ext_attr, $total_amount_price, $is_admin]);
    }

    public function updateUser($id, $username, $password, $email, $image, $room_id, $ext_attr, $total_amount_price, $is_admin)
    {
        $stmt = $this->db->prepare('UPDATE users SET username = ?, password = ?, email = ?, image = ?, room_id = ?, ext_attr = ?, total_amount_price = ?, is_admin = ? WHERE id = ?');
        return $stmt->execute([$username, $password, $email, $image, $room_id, $ext_attr, $total_amount_price, $is_admin, $id]);
    }

    public function updateUserTotalAmount($id,$total_amount_price)
    {
        $stmt = $this->db->prepare('UPDATE users SET total_amount_price = ? WHERE id = ?');
        return $stmt->execute([$total_amount_price, $id]);
    }

    public function updateUserPassword($email, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('UPDATE users SET password = :password WHERE email = :email');
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = ?');
        return $stmt->execute([$id]);
    }
}

