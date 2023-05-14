<?php
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/views/layouts/navbar.php');
include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/controllers/category_controller.php');
$categoryController = new CategoryController();
$categories = $categoryController->show($_GET['id']);

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';


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
        <h1>Update Category Data</h1>
    </div>
    <form method="POST" id="<?php echo $categories['id']; ?>" class="my_form">
        <label for="prd_name">Product Name:</label>
        <input type="text" class="form-control" id="name" name="cat_name" value="<?php echo $categories['name']; ?>"><br>


        <div class="text-center">
            <button type="submit" class="btn btn-success mt-3 w-25">Save</button>

        </div>
    </form>
</div>
<script>
    document.querySelector('.my_form').addEventListener('submit', function(event) {
        event.preventDefault(); // prevent default form submission behavior
        let formData = new FormData();
        formData.append('id', document.querySelector('.my_form').id);
        formData.append('name', document.getElementById('name').value);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/CafeteriaSystem/controllers/admin/categoryActions/updateCategory.php', true);
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                // alert(xhr.responseText);
                window.location.href = '/CafeteriaSystem/views/admin/categories/allCategories.php';
            }
        }
        xhr.send(formData);
    });
</script>
</body>
</html>



