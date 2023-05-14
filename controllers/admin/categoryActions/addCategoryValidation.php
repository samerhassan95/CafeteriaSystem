<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/category_controller.php');
$categoryController = new CategoryController();
$categories = $categoryController->create();
?>
