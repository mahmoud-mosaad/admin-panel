<?php

require "./model/user.php";
require './database/QueryBuilder.php';
class UsersController
{
    private $model;
    public function __construct()
    {
        $this->model= new User();
    }

    public function add()
    {
        $this->model->add($_POST['name'],$_POST['email'],$_POST['password']);
        return header("Location: /index.php?controller=UsersController&method=show");
    }

    public function edit()
    {
        $this->model->edit($_GET['edit'],$_POST['name'],$_POST['email'],$_POST['password']);
        return header("Location: /index.php?controller=UsersController&method=show");
    }

    public function delete()
    {
        $this->model->delete($_GET['delete']);
        return header("Location: /index.php?controller=UsersController&method=show");
    }

    public function show()
    {
        $select = new QueryBuilder;
        $users = $select->selectAll("users");
        require('./view/usersview.php');
    }

}