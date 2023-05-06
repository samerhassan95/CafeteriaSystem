<?php

require_once('../../config/database.php');

        // Start Validation of the Users Data
        $errors = [];
        $formvalues = [];
        
        if(isset($_POST["sub"])){
          $fields = ["username" => "Username", "email" => "Email", "password" => "Password", "confirm" => "Confirm password", "room_id" => "NO.ROOM", "ext_attr" => "NO.exit"];
          foreach($fields as $field => $label){
            if(empty($_POST[$field])){
              $errors[$field] = "$label is Required";
            } else {
              $formvalues[$field] = $_POST[$field];
            }
          }
          
          if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $errors["email"] = "Email is Invalid";
          }
          
          if($_POST["confirm"] != $_POST["password"]){
            $errors["confirm"] = "Password isn't matched";
          }
        
          $formerrors=json_encode($errors);

          if($errors){
             $id = $_GET['id'];
             $redirect_url = "Location:edit.php?id={$id}&errors={$formerrors}";
             header($redirect_url);
          }
        // End Validation of the Users Data  

        if(!$errors){
          $id = $_GET['id'];
          $username = $_POST['username'];
          $useremail = $_POST['email'];
          $password = $_POST['password'];
          $userroom = $_POST['room_id'];
          $userexit = $_POST['ext_attr'];
      
          try{
              if($db){
                  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                  
                  $select_query = "UPDATE users SET `username` = :username, `email` = :useremail, `password` = :hashed_password, `room_id` = :userroom, `ext_attr` = :userexit WHERE id = :id";
                  $stmt = $db->prepare($select_query);
                  $stmt->bindParam('id', $id, PDO::PARAM_INT);
                  $stmt->bindParam('username', $username, PDO::PARAM_STR);
                  $stmt->bindParam('useremail', $useremail, PDO::PARAM_STR);
                  $stmt->bindParam('hashed_password', $hashed_password, PDO::PARAM_STR);
                  $stmt->bindParam('userroom', $userroom, PDO::PARAM_STR);
                  $stmt->bindParam('userexit', $userexit, PDO::PARAM_STR);
                
                  $res = $stmt->execute();
                  if($stmt->rowCount()){
                      echo "updated";
                      header("location:displayUsers.php");
                  }
              }
          }catch(Exception $e){
              echo $e->getMessage();
          }
      }

}
    
      