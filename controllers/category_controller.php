<?php
// controllers/category_controller.php

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/models/category_model.php');

class CategoryController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategoryModel(include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/config/database.php"));
    }

    public function index()
    {
        return $this->model->getAllCategories();

    }

    public function show($id)
    {
        return $this->model->getCategoryById($id);

    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $errors = array();
            $oldValues = array();
            if(empty($_POST['cat_name']))
            {
                $errors['name'] = "Category name is required";
            }
            else
            {
                $oldValues['name'] = $_POST['cat_name'];
            }

            if(count($errors)>0){
                $_SESSION['errors'] = $errors;
                $_SESSION['oldValues'] = $oldValues;
                header("Location: /CafeteriaSystem/views/admin/categories/addCategory.php");
                exit();
            }
            else{
                $this->model->createCategory($_POST['cat_name']);
                header('Location: /CafeteriaSystem/views/admin/categories/allCategories.php');
            }

        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $this->model->updateCategory($id, $name);
//            header('Location: /categories');
        }
//        else {
//            $category = $this->model->getCategoryById($id);
//            include 'views/update_category.php';
//        }
    }

    public function delete($id)
    {
        $this->model->deleteCategory($id);
//        header('Location: /categories');
    }
}