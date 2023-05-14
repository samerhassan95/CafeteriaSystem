<?php
// models/category_model.php

class CategoryModel
{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getAllCategories()
    {
        $stmt = $this->db->prepare('SELECT * FROM Categories');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM Categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCategory($name)
    {
        $stmt = $this->db->prepare('INSERT INTO Categories (name) VALUES (?)');
        return $stmt->execute([$name]);
    }

    public function updateCategory($id, $name)
    {
        $stmt = $this->db->prepare('UPDATE Categories SET name = ? WHERE id = ?');
        return $stmt->execute([$name, $id]);
    }

    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare('DELETE FROM Categories WHERE id = ?');
        return $stmt->execute([$id]);
    }
}