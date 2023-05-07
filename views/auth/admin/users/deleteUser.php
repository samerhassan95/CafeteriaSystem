<?php

include($_SERVER["DOCUMENT_ROOT"] . '/cafeITI/config/database.php');

if($db){
    try {
        $query = "DELETE FROM `cafeteria`.`users` WHERE id=:id";
        $stmt = $db->prepare($query);
        
        $id = $_GET['id']; 
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        
        $query_execute = $stmt->execute();
        header("Location:displayUsers.php");
    } catch(PDOException $e){
        echo $e->getMessage();
    }
}

?>