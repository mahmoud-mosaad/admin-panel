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
        require 'entity/User.php';

        $roles = array();

        $roles['select'] = array(1 , isset($_POST['select'])?1:0);
        $roles['create'] = array(2 , isset($_POST['create'])?1:0);
        $roles['update'] = array(3 , isset($_POST['update'])?1:0);
        $roles['delete'] = array(4 , isset($_POST['delete'])?1:0);

        $user = new User($_POST['name'],$_POST['email'],$_POST['password'], $roles);

        $this->model->add($user);
        return header("Location: index.php?controller=UserController&method=show");
    }

    public function edit()
    {
        require 'entity/User.php';

        $roles = array();

        $roles['select'] = array(1 , isset($_POST['select'])?1:0);
        $roles['create'] = array(2 , isset($_POST['create'])?1:0);
        $roles['update'] = array(3 , isset($_POST['update'])?1:0);
        $roles['delete'] = array(4 , isset($_POST['delete'])?1:0);


        $user = new User($_POST['name'],$_POST['email'],$_POST['password'], $roles);
        $this->model->edit($user,$_GET['edit']);
        return header("Location: index.php?controller=UserController&method=show");
    }

    public function delete()
    {
        $this->model->delete($_GET['delete']);
        return header("Location: index.php?controller=UserController&method=show");
    }

    public function show()
    {

        //$users = $this->model->retrieveAll("users");

        $users = $this->model->retrieveAllUsers();
        $roles = $this->model->retrieveAllUsersRoles($users);
        require('./view/usersview.php');
    }
    public function search()
    {
        if($_POST['search']=="name") $users = $this->model->retrieveSearchedUsers("users",$_POST["search"],$_POST["value"]);
        if($_POST['search']=="email") $users = $this->model->retrieveSearchedUsers("users",$_POST["search"],$_POST["value"]);
        $roles = $this->model->retrieveAllUsersRoles($users);
        require('./view/usersview.php');
    }
    public function recentAdded()
    {
        $users = $this->model->retrieveSearchedUsers("users",$_POST["search"],$_POST["value"]);
        require('./view/usersview.php');
    }

}