<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/user_controller.php");
$userController = new UserController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $userController->delete($id);
} 

?>