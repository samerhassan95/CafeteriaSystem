<?php

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';

session_start();

require_once('../config/database.php');

$errors = [];

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(isset($_POST["email"]) && isset($_POST["password"]))
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql="SELECT * FROM users WHERE email = :email";

        $stmt = $db->prepare($sql);
        $stmt->execute(array(':email' => $email));
        $row = $stmt->fetch();

        if($row !== false && password_verify($password, $row["password"]) && $row["is_admin"] == 0)
        {  
            $_SESSION["email"] = $email;
            header("Location: user/userPage.php");
        }
        elseif($row !== false && password_verify($password, $row["password"]) && $row["is_admin"] == 1)
        {
            $_SESSION["email"] = $email;
            header("Location: admin/adminPage.php");
        }
        else
        {
            if($row === false){
                $errors["email"] = "This Email does not exist";
            }
            else {
                $errors["password"] = "Incorrect password";
            }
        }
    }
    else
    {
        $errors["email"] = "Email or password not set";
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<section class="vh-100">
  <div class="container-fluid h-custom ">
    <div class="row d-flex justify-content-center align-items-center h-100 ">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="../public/images/logo2.png"
          class="img-fluid" alt="logo" style="width: 75%; margin: 0 0 30px 25px ">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 ">
        <form action="" method="POST" class="border p-4">
          <div class="form-outline mb-4">
            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter email address" />
          </div>
          <div class="text-danger"> <?php if(isset($errors["email"])) echo $errors["email"]; ?></div>
          <div class="form-outline mb-3">
            <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter password" />
          </div>
          <div class="text-danger"> <?php if(isset($errors["password"])) echo $errors["password"]; ?></div>
          <div class="d-flex justify-content-between align-items-center">
            <a href="forgotPassword.php" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

</body>
</html>
