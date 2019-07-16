<?php

require "./model/UserModel.php";
class UserController
{
    private $model;
    public function __construct()
    {
        $this->model= new UserModel();
    }

    public function add()
    {
        $this->model->add($_POST['name'],$_POST['email'],$_POST['password']);
        return header("Location: index.php?controller=UserController&method=show");
    }

    public function edit()
    {
        $this->model->edit($_GET['edit'],$_POST['name'],$_POST['email'],$_POST['password']);
        return header("Location: index.php?controller=UserController&method=show");
    }

    public function delete()
    {
        $this->model->delete($_GET['delete']);
        return header("Location: index.php?controller=UserController&method=show");
    }

    public function show()
    {
        $users = $this->model->retrieve("users");
        require('./view/usersview.php');
    }

}