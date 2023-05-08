<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $errors = array();
    $oldValues = array();
    if(empty($_POST['cat_name']))
    {
        $errors['name'] = "Category name is required";
    }
    else
    {
        $oldValues['name'] = $_POST['cat_name'];
    }

    if(count($errors)>0){
        $_SESSION['errors'] = $errors;
        $_SESSION['oldValues'] = $oldValues;
        header("Location: addCategory.php");
        exit();
    }
    else{
        $db = include($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/config/database.php");
        $stmt = $db->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->bindParam(':name', $_POST['cat_name']);
        $result = $stmt->execute();

        if ($result) {
            header("Location:../productActions/addProduct.php");
        } else {
        }
    }

}
?>