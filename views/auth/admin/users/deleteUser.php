<?php

<<<<<<< HEAD
// require_once('../../../../config/database.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/controllers/user_controller.php");
=======
include($_SERVER["DOCUMENT_ROOT"] . '/cafeITI/config/database.php');
>>>>>>> eeb8b46d1482b4e55a962cad0c2cc60aadd6afa9

$userController = new UserController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $userController->delete($id);
} 

?>