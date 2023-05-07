<?php
// models/product_model.php

class ProductModel
{

    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getAllProducts()
    {
        $stmt = $this->db->prepare('SELECT * FROM Products');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM Products WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($name, $description, $price, $category_id, $image)
    {
        $stmt = $this->db->prepare('INSERT INTO Products (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)');
        return $stmt->execute([$name, $description, $price, $category_id, $image]);
    }

    public function updateProduct($id, $name, $description, $price, $category_id, $image)
    {
        $stmt = $this->db->prepare('UPDATE Products SET name = ?, description = ?, price = ?, category_id = ?, image = ? WHERE id = ?');
        return $stmt->execute([$name, $description, $price, $category_id, $image, $id]);
    }

    public function deleteProduct($id)
    {
        $stmt = $this->db->prepare('DELETE FROM Products WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
