<?php
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';

session_start();

// Check if the email is set in the session, if not redirect to the login page
if (!isset($_SESSION["email"])) {
  header("Location:login.php");
  exit();
}

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/user_controller.php');
$UserController = new UserController();

// Get the email from the session
$email = $_SESSION['email'];

$errors = [];
$new_password = "";

if (isset($_POST['submit'])) {
  $new_password = trim($_POST['new_password']);
  $confirm_password = trim($_POST['confirm_password']);

  if (empty($new_password)) {
    $errors['new_password'] = 'Please enter your new password';
  }
  if (empty($confirm_password)) {
    $errors['confirm_password'] = 'Please confirm your new password';
  }

  if (empty($errors)) {
    if ($new_password != $confirm_password) {
      $errors['confirm_password'] = 'The passwords do not match';
    } else {


      $result = $UserController->UpdatePassword($email, $new_password);
      if ($result['status'] == 'success') {

        session_destroy();
        header("Location: login.php");
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/cafeITI/public/styles/resetPassword.css">
  <title>Document</title>
</head>

<body>
  <div class="d-flex justify-content-center mt-3">
    <div class="card text-center" style="width: 300px;">
      <div class="card-header h5 text-white bg-primary">Change password</div>
      <div class="card-body px-5">
        <form method="post" action="">
          <div class="form-group">
            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password">
          </div>
          <div class="text-danger"> <?php if (isset($errors["new_password"])) echo $errors["new_password"]; ?></div>
          <br>
          <div class="form-group">
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password">
          </div>
          <div class="text-danger"> <?php if (isset($errors["confirm_password"])) echo $errors["confirm_password"]; ?></div>
          <button type="submit" name="submit" class="btn btn-primary btn-block submit-btn">Confirm</button>
        </form>
      </div>
    </div>
  </div>

</body>

</html>