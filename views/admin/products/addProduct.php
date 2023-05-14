<?php

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/views/layouts/navbar.php');

if(isset($_SESSION['errors'])){
    if(isset($_SESSION['errors']['name']))
        $name_err = $_SESSION['errors']['name'];
    else
        $old_name = $_SESSION['oldValues']['name'];

    if(isset($_SESSION['errors']['price']))
        $price_err = $_SESSION['errors']['price'];
    else
        $old_price = $_SESSION['oldValues']['price'];

    if(isset($_SESSION['errors']['cat']))
        $cat_err = $_SESSION['errors']['cat'];
    else
        $old_cat = $_SESSION['oldValues']['cat'];

    if(isset($_SESSION['errors']['img']))
        $img_err = $_SESSION['errors']['img'];
    else
        $old_img = $_SESSION['oldValues']['img'];

    // Clear the errors from the session
    unset($_SESSION['errors']);




}

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/category_controller.php");
$category_controller = new CategoryController();
$categories = $category_controller->index();
//var_dump($categories);
//exit();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>AddProduct</title>
</head>
<body>
<h1 class="fs-1 fw-bold text-center mt-5">Add Product</h1>
    <div class="container d-flex justify-content-center">
        <form action="/CafeteriaSystem/controllers/admin/productActions/addProductValidation.php" method="POST" enctype="multipart/form-data" class="w-50 border p-3 mt-2">
            <div class="form-group mb-4">
                <label class="form-label fs-5" for="prd_name">Name</label>
                <input type="text" class="form-control" id="prd_name" name="prd_name" value="<?php if(isset($old_name)) echo $old_name?>">
                <span><?php if(isset($name_err)) echo "<p class='text-danger'>$name_err</p>"?></span>
            </div>

            <div class="form-group mb-4">
                <label class="form-label fs-5" for="prd_price">Price</label>
                <input type="number" class="form-control w-25" id="prd_price" min="0" name="prd_price" value="<?php if(isset($old_price)) echo $old_price?>">
                <span><?php if(isset($price_err)) echo "<p class='text-danger'>$price_err</p>"?></span>

            </div>

            <div class="d-flex justify-content-between align-items-center">

                <div class="form-group mb-4 col-8">
                    <label class="form-label fs-5" for="prd_cat">Category</label>
                    <select class="form-select" id="prd_cat" name="prd_cat">
                        <option selected></option>
                        <?php
                        foreach ($categories as $cat)
                        {
                            echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                        }
                        ?>
                    </select>
                    <span><?php if(isset($cat_err)) echo "<p class='text-danger'>$cat_err</p>"?></span>
                </div>
                <div>
                    <a class="m col-3" href="/CafeteriaSystem/views/admin/categories/addCategory.php">Add Category</a>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="form-label fs-5" for="prd_img">Image</label>
                <input type="file" class="form-control" id="prd_img" name="prd_img">
                <span><?php if(isset($img_err)) echo "<p class='text-danger'>$img_err</p>"?></span>
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
