<?php

// require_once('../../../../config/database.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/controllers/user_controller.php");

$userController = new UserController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $userController->delete($id);
} 

?>