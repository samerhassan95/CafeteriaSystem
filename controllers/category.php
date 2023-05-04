<?php

require_once('../config/database.php');

session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $errors = array();

    if (empty($category_name)) {
        $errors['category_name'] = 'Please enter a category name';
    }

    if (empty($errors)) {
        // Insert the category into the database
        $stmt = $db->prepare('INSERT INTO category (category_name) VALUES (:category_name)');
        $stmt->bindParam(':category_name', $category_name);
        $stmt->execute();

        // header('Location: categories.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Add Category</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" >
            </div>
            <div class="text-danger"> <?php if(isset($errors["category_name"])) echo $errors["category_name"]; ?></div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add">
                <a href="products.php" class="btn btn-link">Cancel</a>
            </div>

        </form>
    </div>
</body>
</html>