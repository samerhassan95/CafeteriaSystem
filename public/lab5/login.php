<?php

if (isset($_GET["errors"])) {
    $errors = json_decode($_GET["errors"], true);
}
if (isset($_GET["old"])) {
    $old_data = json_decode($_GET["old"], true);
}
if(isset($_GET['message'])){
    $message = $_GET['message'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>

<div style="width:100vw;" class="d-flex justify-content-center align-items-center mt-5">

    <form class="container" action="loginValidate.php" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label" for="email">Email:</label><br/>
            <input class="form-control" type="text" id="email" name="email"
                   value="<?php if (isset($old_data['email'])) echo $old_data['email']; ?>"/>
            <div class="text-danger"> <?php if (isset($errors['email'])) echo $errors['email']; ?> </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Password:</label><br/>
            <input class="form-control" type="password" id="password" name="password"/>
            <div class="text-danger"> <?php if (isset($errors['password'])) echo $errors['password']; ?> </div>
        </div>
        <div class="text-danger"> <?php if (isset($message)) echo $message; ?> </div>
        <input type="submit" class="btn btn-primary" value="Submit"/>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>
<script src="register.js"></script>
</body>

</html>