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
    public function getAllCats()
    {
        $stmt = $this->db->prepare('SELECT * FROM categories');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($name, $price, $category, $image) {
        $stmt = $this->db->prepare("INSERT INTO products (name, price, category_id, image) VALUES (:name, :price, :category, :image)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateProduct($id, $name, $price, $category,$image) {
        $stmt = $this->db->prepare("UPDATE products SET name=:name, price=:price, category_id=:category, image=:image WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
        return $stmt->rowCount();
    }


    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
