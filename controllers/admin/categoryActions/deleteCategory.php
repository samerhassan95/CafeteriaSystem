<?php

$id = $_GET['id'];
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/category_controller.php');
$categoryController = new CategoryController();
$categoryController->delete($id);
header('Location: /CafeteriaSystem/views/admin/categories/allCategories.php');
exit();