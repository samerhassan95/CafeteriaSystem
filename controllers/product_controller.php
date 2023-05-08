<?php
// controllers/product.php
include($_SERVER["DOCUMENT_ROOT"] . '/cafeITI/models/product_model.php');

class ProductController
{

    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel(include($_SERVER["DOCUMENT_ROOT"] . '/cafeITI/config/database.php'));
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();
        return $products;
    }

    public function create()
    {
        // load the view to display the form to create a new product
    }

    public function store()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $image = $_POST['image'];

        // validate input

        $result = $this->productModel->createProduct($name, $description, $price, $category_id, $image);
        if ($result) {
            // redirect to the list of products with success message
        } else {
            // reload the form with error message
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        // load the view to display the form to edit the product, passing in the $product array as a variable
    }

    public function update($id)
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $image = $_POST['image'];

        // validate input

        $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
        if ($result) {
            // redirect to the list of products with success message
        } else {
            // reload the form with error message
        }
    }

    public function delete($id)
    {
        $result = $this->productModel->deleteProduct($id);
        if ($result) {
            // redirect to the list of products with success message
        } else {
            // redirect to the list of products with error message
        }
    }
}
