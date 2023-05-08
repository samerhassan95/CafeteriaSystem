<?php

$id = $_GET['id'];
include '../../product_controller.php';
$productController = new ProductController();
$productController->delete($id);
header("Location:allProducts.php");
