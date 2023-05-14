<?php
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/views/layouts/navbar.php');
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/product_controller.php');
$productController = new ProductController();
$categories = $productController->getAllCats();
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';


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

try {
    $neededProduct = $productController->getProductById($_GET['id']);
} catch (PDOException  $ex) {
    $error_message = $ex->getMessage();
    echo "Error: " . $error_message;
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
</head>
<body>
<div class="container mt-5 col-5 bg-light text-dark p-5 rounded">
    <div class="text-center m-3">
        <h1>Update Product Data</h1>
    </div>
    <form method="POST" enctype="multipart/form-data" action="/CafeteriaSystem/controllers/admin/productActions/updateProduct.php?id=<?php echo $_GET['id']; ?>"
          id="<?php echo $neededProduct['id']; ?>" class="my_form">
        <div class="form-group mb-4">
            <label class="form-label fs-5" for="prd_name">Product Name:</label>
            <input type="text" class="form-control" id="prd_name" name="prd_name"
                   value="<?php echo isset($old_name) ? $old_name : $neededProduct['name']; ?>"><br>
            <span><?php if (isset($name_err)) echo "<p class='text-danger'>$name_err</p>" ?></span>
        </div>

        <div class="form-group mb-4">
            <label class="form-label fs-5" for="prd_price">Price</label>
            <input type="number" class="form-control" id="price" name="prd_price" min="0"
                   value="<?php echo isset($old_price) ? $old_price:$neededProduct['price'];?>">
            <span><?php if (isset($price_err)) echo "<p class='text-danger'>$price_err</p>" ?></span>

        </div>


        <div class="form-group mb-4 col-8">
            <label for="prd_cat" class="form-label">Category</label>
            <select class="form-select" id="prd_cat" name="prd_cat">
                <option selected></option>
                <?php
                foreach ($categories as $cat) {
                    $selected = ($cat['id'] == $neededProduct['category_id']) ? 'selected' : ''; // check if cat id matches product category id

                    echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>"; // add 'selected' attribute if condition is true
                }
                ?>
            </select>
            <span><?php if (isset($cat_err)) echo "<p class='text-danger'>$cat_err</p>" ?></span>
        </div>

        <div class="form-group mb-4">
            <label class="form-label fs-5" for="prd_img">Image</label>
            <input type="file" class="form-control" id="prd_img" name="prd_img">
            <span><?php if(isset($img_err)) echo "<p class='text-danger'>$img_err</p>"?></span>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success mt-3 w-25">Save</button>

        </div>
    </form>
</div>
<script>
    // document.querySelector('.my_form').addEventListener('submit', function (event) {
    //     event.preventDefault(); // prevent default form submission behavior
    //     let formData = new FormData();
    //     formData.append('id', document.querySelector('.my_form').id);
    //     formData.append('prd_name', document.getElementById('prd_name').value);
    //     formData.append('prd_price', document.getElementById('prd_price').value);
    //     formData.append('prd_cat', document.getElementById('prd_cat').options[document.getElementById('prd_cat').selectedIndex].id);
    //     formData.append('prd_img', document.getElementById('prd_img').options[document.getElementById('prd_cat').selectedIndex].id);
    //
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('POST', '/CafeteriaSystem/controllers/admin/productActions/updateProduct.php', true);
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState == 4 && xhr.status == 200) {
    //             // alert(xhr.responseText);
    //             window.location.href = '/CafeteriaSystem/views/admin/products/allProducts.php';
    //         }
    //     }
    //     xhr.send(formData);
    // });
</script>
</body>
</html>



