<?php

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/user_controller.php');

$UserController = new UserController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $UserController->login();
    if ($result['status'] == "success") {
        if ($result['admin'] == "true") {
            header("Location: http://localhost/CafeteriaSystem/views/admin/adminPage.php");
        } else {
            header("Location: http://localhost/CafeteriaSystem/views/user/userPage.php");
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        body {
            background-image: url(/CafeteriaSystem/public/images/loginbackground.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>

<section class="vh-100">
    <div class="container-fluid h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-6 col-xl-5 mt-4">
                <img src="/CafeteriaSystem/public/images/logo2.png" class="img-fluid" alt="logo"
                     style="width: 26em">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form action="" method="POST" class="border p-4 shadow-lg p-3 mb-5 bg-body rounded mt-5" >
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control form-control-lg"
                               placeholder="Enter email address"/>
                        <?php if (isset($result["input"]) && $result["input"] == "Email") { ?>
                            <div class="text-danger"><?php echo $result["error"]; ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-outline mb-3">
                        <input type="password" id="password" name="password" class="form-control form-control-lg"
                               placeholder="Enter password"/>
                        <?php if (isset($result["input"]) && $result["input"] == "Password") { ?>
                            <div class="text-danger"><?php echo $result["error"]; ?></div>
                        <?php } ?>
                    </div>
                    <?php if (isset($result["input"]) && $result["input"] == "both") { ?>
                        <div class="text-danger"><?php echo $result["error"]; ?></div>
                    <?php } ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="forgotPassword.php" class="text-body">Forgot password?</a>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>