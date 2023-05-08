<?php
include '../../product_controller.php';
$productController = new ProductController();
$categories = $productController->getAllCats();
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';

try {
    $neededProduct = $productController->getProductById($_GET['id']);
}catch(PDOException  $ex)
{
    $error_message = $ex->getMessage();
    echo "Error: " . $error_message;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productController->update($_GET['id']);

    header('Location: allProducts.php');
    exit();
}

?>

<div class="container mt-5 col-5 bg-light text-dark p-5 rounded">
    <div class="text-center m-3">
        <h1>Update Product Data</h1>
    </div>
    <form method="POST">
        <label for="prd_name">Product Name:</label>
        <input type="text" class="form-control" id="name" name="prd_name" value="<?php echo $neededProduct['name']; ?>"><br>

        <label for="prd_price">Price</label>
        <input type="number" class="form-control" id="email" name="prd_price" value="<?php echo $neededProduct['price']; ?>"><br>

        <label for="prd_cat" class="form-label">Category</label>
        <select class="form-select" id="prd_cat" name="prd_cat">
            <option selected></option>
            <?php
            foreach ($categories as $cat)
            {
                echo "<option>{$cat['name']}</option>";
            }
            ?>
        </select>

        <div class="text-center">
            <button type="submit" class="btn btn-success mt-3 w-25">Save</button>

        </div>
    </form>
</div>


