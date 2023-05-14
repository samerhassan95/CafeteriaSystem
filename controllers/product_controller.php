<?php
// controllers/product.php

// require_once 'C:\xampp\htdocs\CafeSystem2\CafeteriaSystem\models\product_model.php';
include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/models/product_model.php");

class ProductController
{

    private $productModel;


    public function __construct()
    {
        $db = include ($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/config/database.php");
        $ProductModel = new ProductModel($db);
        $this->productModel = $ProductModel;
    }

    public function getAllProducts()
    {
        $products = $this->productModel->getAllProducts();
        return $products;
    }
    public function getAllCats()
    {
        $cats = $this->productModel->getAllCats();
        return $cats;
    }

    public function getProductById($id)
    {
        $product = $this->productModel->getProductById($id);
        return $product;
    }

    public function create()
    {
        // load the view to display the form to create a new product
    }

    public function store()
    {
        $name = $_POST['prd_name'];
        $price = $_POST['prd_price'];
        $category_id = $_POST['prd_cat'];
        $image = $_FILES['prd_img']['name'];
        // validate input
        $result = $this->productModel->createProduct($name, $price, $category_id, $image);
        if ($result) {
            // redirect to the list of products with success message
            header("Location: /CafeteriaSystem/views/admin/products/allProducts.php");
        } else {
            // reload the form with error message
            echo 'no';
        }
    }

    public function editProduct($id)
    {
        $product = $this->productModel->getProductById($id);
        // load the view to display the form to edit the product, passing in the $product array as a variable
    }

    public function update()
    {
        $id = $_GET['id'];
        $name = $_POST['prd_name'];
        $price = $_POST['prd_price'];
        $category_id = $_POST['prd_cat'];
        $image = $_FILES['prd_img']['name'];

        // validate input

        $result = $this->productModel->updateProduct($id,$name, $price, $category_id, $image);
        if ($result) {
            // redirect to the list of products with success message
        } else {
            // reload the form with error message
        }
    }

    public function delete($id)
    {
        $result = $this->productModel->deleteProduct($id);
        if ($result) {
            // redirect to the list of products with success message
        } else {
            // redirect to the list of products with error message
        }
    }
}
