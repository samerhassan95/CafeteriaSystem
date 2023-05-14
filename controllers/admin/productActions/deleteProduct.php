<?php

$id = $_GET['id'];
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/product_controller.php');
$productController = new ProductController();
$productController->delete($id);
header('Location: /CafeteriaSystem/views/admin/products/allProducts.php');
exit();