<?php

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/category_controller.php');
$categoryController = new CategoryController();
$categoryController->update();

//header('Location: /CafeteriaSystem/views/admin/products/allProducts.php');
exit();