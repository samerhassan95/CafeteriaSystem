<?php
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';


include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/user_controller.php');

$UserController = new UserController();

$errors = [];

if (isset($_REQUEST['submit'])) {
  $email = $_REQUEST['email'];
  $result = $UserController->ForgetPassword($email);
  if ($result) {
    session_start();
    $_SESSION['email'] = $email;
    header("Location: resetPassword.php");
    exit();
  } else {
    $errors["email"] = "This Email does not exist";
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
<style>
  body {
    background-color: #f5f5f5;
  }
</style>

<body>
  <div class="d-flex justify-content-center">
    <div class="card text-center" style="width: 300px; margin-top: 80px">
      <div class="card-header h5 text-white bg-primary">Password Reset</div>
      <img src="http://localhost/CafeteriaSystem/public/images/padlock.png" class="img-fluid mx-auto" style="max-width: 140px; height: auto; margin-top: 20px;">
      <div class="card-body px-5">
        <form id="validate_form" method="post">
          <div class="form-group">
            <input type="email" name="email" placeholder="Enter Email" required class="form-control">
            <div class="text-danger"> <?php if (isset($errors["email"]))  echo $errors["email"]; ?></div><br>
          </div>
          <div class="form-group text-center">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Reset Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>