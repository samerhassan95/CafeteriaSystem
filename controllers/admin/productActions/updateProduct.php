<?php


session_start();
$image = $_FILES['prd_img']['name'];
$target_dir = $_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/public/images/products/";
$target_file = $target_dir . basename($image);
$allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
$file_extension = strtolower(pathinfo($_FILES['prd_img']['name'], PATHINFO_EXTENSION));

$errors = array();
$oldValues = array();
if (empty($_POST['prd_name'])) {
    $errors['name'] = "Product name is required";
} else {
    $oldValues['name'] = $_POST['prd_name'];
}

if (empty($_POST['prd_price'])) {
    $errors['price'] = "Product price is required";
} else {
    $oldValues['price'] = $_POST['prd_price'];
}

if (empty($_POST['prd_cat'])) {
    $errors['cat'] = "Product category is required";
} else {
    $oldValues['cat'] = $_POST['prd_cat'];
}

if (empty($_FILES['prd_img'])) {
    $errors['img'] = "Product image is required";
} elseif (!in_array($file_extension, $allowed_extensions)) {
    $errors['img'] = "Not Supported Type";
} else {
    $oldValues['img'] = $_FILES['prd_img'];
}

if (count($errors) > 0) {
    $_SESSION['errors'] = $errors;
    $_SESSION['oldValues'] = $oldValues;
    header("Location: /CafeteriaSystem/views/admin/products/editProduct.php?id={$_GET['id']}");
    exit();
} else {


    // Check if the file is an image
    if (in_array($file_extension, $allowed_extensions)) {
        move_uploaded_file($_FILES["prd_img"]["tmp_name"], $target_file);
    }
    if (empty($_FILES['prd_img'])) {
        $errors['img'] = "Product image is required";
    }

    include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/product_controller.php');
    $productController = new ProductController();
    $productController->update();

}


header('Location: /CafeteriaSystem/views/admin/products/allProducts.php');
exit();