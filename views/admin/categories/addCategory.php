<?php
include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/views/layouts/navbar.php");

if(isset($_SESSION['errors'])){
    if(isset($_SESSION['errors']['name']))
        $name_err = $_SESSION['errors']['name'];
    else
        $old_name = $_SESSION['oldValues']['name'];
    // Clear the errors from the session
    unset($_SESSION['errors']);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Add Category</title>
</head>
<body>
<h1 class="fs-1 fw-bold text-center mt-5">Add Category</h1>
<div class="container d-flex justify-content-center">
    <form action="/CafeteriaSystem/controllers/admin/categoryActions/addCategoryValidation.php" method="POST" class="w-50 border p-3 mt-2">
        <div class="form-group mb-4">
            <label class="form-label fs-5" for="cat_name">Name</label>
            <input type="text" class="form-control" id="prd_name" name="cat_name" value="<?php if(isset($old_name)) echo $old_name?>">
            <span><?php if(isset($name_err)) echo "<p class='text-danger'>$name_err</p>"?></span>
        </div>

        <div class="d-flex justify-content-around mt-5">
            <input type="submit" class="btn btn-success w-25" value="SAVE">
            <button type="reset" class="btn btn-danger w-25">RESET</button>
        </div>

    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
