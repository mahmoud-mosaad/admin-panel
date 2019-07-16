<?php

require "./model/category.php";
//require './database/QueryBuilder.php';
class CategoryController
{
    private $model;
    public function __construct()
    {
        $this->model= new Category();
    }

    public function add()
    {
        $this->model->add($_POST['name'],$_POST['description']);
        return header("Location: /index.php?controller=CategoryController&method=show");
    }

    public function edit()
    {
        $this->model->edit($_GET['edit'],$_POST['name'],$_POST['description']);
        return header("Location: /index.php?controller=CategoryController&method=show");
    }

    public function delete()
    {
        $this->model->delete($_GET['delete']);
        return header("Location: /index.php?controller=CategoryController&method=show");
    }

    public function show()
    {
        $select = new QueryBuilder;
        $categorys = $select->selectAll("category");
        require('./view/categoryview.php');
    }

}