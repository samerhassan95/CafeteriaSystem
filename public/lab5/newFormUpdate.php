<?php

include "connectionDB.php";

$id = $_GET["id"];

$db = new Database('localhost', 'phplabs', 'root', '12345');
$conn = $db->connect();

$user = $db->selectUser('users','id',$id);
$userSkills = explode(',', $user["skills"]);

//var_dump($user);
//exit;
//$f_name = $_GET["f_name"];
//$l_name = $_GET["l_name"];
//$gender = $_GET["gender"];
//$email = $_GET["email"];
//$username = $_GET["username"];
//$department = $_GET["department"];
//$address = $_GET["address"];
//$country = $_GET["country"];
//$skills = $_GET["skills"];

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

<div style="width:100vw;" class="d-flex justify-content-center align-items-center">

    <form class="container" action="edituser.php?id=<?php echo $id; ?> " method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="fname" class="form-label">First name:</label><br/>
            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $user["FirstName"]; ?>"/>
            <div class="text-danger"> <?php if (isset($errors['fname'])) echo $errors['fname']; ?> </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="lname">Last name:</label><br/>
            <input class="form-control" type="text" id="lname" name="lname" value="<?php echo $user["LastName"]; ?>"/>
            <div class="text-danger"> <?php if (isset($errors['lname'])) echo $errors['lname']; ?> </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="username">Username:</label><br/>
            <input class="form-control" type="text" id="username" name="username" value="<?php echo $user["username"]; ?>"/>
            <div class="text-danger"> <?php if (isset($errors['username'])) echo $errors['username']; ?> </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email:</label><br/>
            <input class="form-control" type="text" id="email" name="email" value="<?php echo $user["Email"]; ?>"/>
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">Password:</label><br/>
            <input class="form-control" type="password" id="password" name="password"/>
            <div class="text-danger"> <?php if (isset($errors['password'])) echo $errors['password']; ?> </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="Department">Department:</label>
            <input class="form-control" type="text" id="Department" name="department"
                   value="<?php echo $user["department"]; ?>"/>
            <div class="text-danger"> <?php if (isset($errors['department'])) echo $errors['department']; ?> </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="address">Address:</label><br/>
            <textarea class="form-control" id="address" name="address"><?php echo $user["address"]; ?></textarea>
            <div class="text-danger"> <?php if (isset($errors['address'])) echo $errors['address']; ?> </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="country">Country:</label><br/>
            <select class="form-select" id="country" name="country">
                <option value="Egypt" <?PHP if ($user["country"] == 'egypt') echo 'selected'; ?> >Egypt</option>
                <option value="canada" <?PHP if ($user["country"] == 'canada') echo 'selected'; ?> >Canada</option>
                <option value="usa" <?PHP if ($user["country"] == 'usa') echo 'selected'; ?> >USA</option>
            </select
            >
        </div>

        <div class="mb-3">
            <label>Gender:</label><br/>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="male" name="gender"
                       value="Male" <?PHP if ($user["Gender"] == 'Male') echo 'checked'; ?> />
                <label class="form-check-label" for="male">Male</label><br/>

            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="female" name="gender"
                       value="Female" <?PHP if ($user["Gender"] == 'Female') echo 'checked'; ?>/>
                <label class="form-check-label" for="female">Female</label><br/><br/>
            </div>
            <div class="text-danger"> <?php if (isset($errors['gender'])) echo $errors['gender']; ?> </div>
        </div>

        <div class="mb-3">
            <label>Skills:</label><br/>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="php" name="skills[]" value="php" <?php if (in_array("php", $userSkills)) echo 'checked'; ?>/>
                <label class="form-check-label" for="php"> PHP</label><br/>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="mysql" name="skills[]" value="mysql" <?php if (in_array("mysql", $userSkills)) echo 'checked'; ?>/>
                <label class="form-check-label" for="mysql"> MySQL</label><br/>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="html" name="skills[]" value="html" <?php if (in_array("html", $userSkills)) echo 'checked'; ?>/>
                <label class="form-check-label" for="html"> HTML</label><br/>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id=".net" name="skills[]" value=".net" <?php if (in_array(".net", $userSkills)) echo 'checked'; ?>/>
                <label class="form-check-label" for=".net"> .NET</label><br/><br/>
            </div>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input id="image" class="form-control" type="file" name="image">
        </div>

        <input type="submit" class="btn btn-primary" value="Submit"/>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>
<script src="register.js"></script>
</body>

</html>