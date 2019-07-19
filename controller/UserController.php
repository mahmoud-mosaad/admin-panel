<?php

require "model/UserModel.php";
class UserController
{
    private $model;
    public function __construct()
    {
        $this->model = new UserModel();
    }

    function setCookies($email){
        $exp = time() + (60*60*24*30*12); // 1 Hour
        setcookie("userId", $email, $exp);
        $row = $this->model->retrieveuser($email);
        setcookie("userP", $row['password'], $exp);
    }

    function checkCookies(){
        if (isset($_COOKIE['userId'])){
            $row = $this->model->retrieveuser($_COOKIE['userId']);
            if ($row != false && $_COOKIE['userP'] === $row['password']){
                $_SESSION['userId'] = $_COOKIE['userId'];
                header("Location: index.php?controller=UserController&method=home");
                exit();
            }
        }
    }

    public function checkSession() {
        //if user has login and session has not been removed
        if(isset($_SESSION['userId']))
        {
            //logged in so redirect
            header('Location: index.php?controller=UserController&method=home');
            exit();
        }
    }

    public function logout() {
        unset($_SESSION['userId']);
        session_destroy();
        setcookie("userId", NULL, time() - 600);
        setcookie("userP", NULL, time() - 600);
        header("location: index.php?controller=UserController&method=login");
        exit();
    }

    public function check_register(){

        if ($_POST['name'] == '' || $_POST['inputEmail'] == '' || $_POST['inputPassword'] ==''){
            return 'All data are required ... enter the empty data';
        }

        $row = $this->model->retrieve($_POST['inputEmail']);
        if ($row === false){

            if ($_POST['inputPassword'] != $_POST['confirmPassword']){
                return 'confirm password should equal your password';
            }
            return true;
        }else{
            // repeated email
            return 'This email is already registered';
        }
        return false;
    }


    public function register(){

        $this->checkSession();

        $this->checkCookies();

        require 'view/register.php';
    }

    public function submit_register(){

        if ($_POST) {
            $msg = $this->check_register();
            if ($msg !== true){
                header('Location: index.php?controller=UserController&method=register&error='.$msg);
            }else{
                $this->add(0);
                $_SESSION['userId'] = $_POST['inputEmail'];
                $to_mail = $_POST['inputEmail'];
                $subject = "Thanks";
                $msg = "Dear " . $_POST['name'] . " ... Thanks for registration in admin-panel";
                mail($to_mail, $subject, $msg);

                header("Location: index.php?controller=UserController&method=home");
                //password_hash($password, PASSWORD_DEFAULT)

            }
        }
    }

    public function check_login(){
        if ($_POST['inputEmail'] === "" || $_POST['inputPasswordLogin'] ===""){
            return 'All data are required ... enter the empty data';
        }

        $row = $this->model->retrieveuser($_POST['inputEmail']);

        if ($row !== false){

            //checked username and password
            //if (password_verify($password, $row['password'])){
            if ($row['password'] === $_POST['inputPasswordLogin']){
                //if username and password true, then create session.
                $_SESSION['userId'] = $_POST['inputEmail'];
                return true;
            }else{
                return 'wrong password .. enter valid password';
            }
        }
        return 'This email is not registered yet';
    }

    public function login(){

        $this->checkSession();

        $this->checkCookies();

        require 'view/login.php';
    }

    public function submit_login(){
        if (!empty($_POST)){

            $msg = $this->check_login();

            if ($msg !== true){
                header('Location: index.php?controller=UserController&method=login&error='.$msg);
            }else{
                if (isset($_POST['rememberme'])){
                    $this->setCookies($_POST['inputEmail']);
                }
                header("Location: index.php?controller=UserController&method=home");
                exit();
            }

        }
    }

    public function home(){

        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location: index.php?controller=UserController&method=login');
            exit();
        }

        $this->show();
    }

    public function resetPassword(){
        if (isset($_GET['token'])){
            $row = $this->model->retrieveAllWhere("tokens", "token", $_GET['token']);
            if ($row === false){
                header('Location: index.php?controller=UserController&method=login');
            }else {
                $time = time();
                if (strtotime($row[0]->expire) > $time) {
                    $_SESSION['token'] = $_GET['token'];
                    require 'view/resetpassword.php';
                }
                else{
                    header('Location: index.php?controller=UserController&method=login');
                }
            }
        }
        else{
            header('Location: index.php?controller=UserController&method=login&error=there is no token');
        }

    }

    public function submit_resetPassword(){
        if (isset($_POST['inputPassword']) && isset($_POST['confirmPassword'])
            && $_POST['inputPassword'] != $_POST['confirmPassword']){
            $msg = 'confirm password should equal your password';
            header('Location: index.php?controller=UserController&method=resetPassword&error='.$msg);
        }else{

            $row = $this->model->retrieveAllWhere("tokens", "token", $_SESSION['token']);

            $this->model->changePassword($row[0]->email,$_POST['inputPassword']);

            $this->model->deleteToken($row[0]->email);
            unset($_SESSION['token']);
            header('Location: index.php?controller=UserController&method=login');

        }
    }

    public function forgetPassword(){
        require 'view/forgetpassword.php';
    }

    public function submit_forgetPassword(){

        $token = uniqid();
        $timestamp = time() + 86400;

        $this->model->addToken($token, $_POST['inputEmail'] ,date('Y-m-d H:i:s',$timestamp));


        $to_mail = $_POST['inputEmail'];
        $subject = "admin-panel";
        $msg = " <a class=\"d-block small\" href=\"http://localhost:8080/admin-panel/index.php?controller=UserController&method=resetPassword&token=$token\">reset Password</a>";
        $headers = "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to_mail, $subject, $msg, $headers);

        header('Location: index.php?controller=UserController&method=login');

    }

    public function add($value)
    {
        require 'entity/User.php';

        $roles = array();

        $roles['select'] = array(1 , ($value==0)?(0):(isset($_POST['select'])?1:0));
        $roles['create'] = array(2 , ($value==0)?(0):(isset($_POST['create'])?1:0));
        $roles['update'] = array(3 , ($value==0)?(0):(isset($_POST['update'])?1:0));
        $roles['delete'] = array(4 , ($value==0)?(0):(isset($_POST['delete'])?1:0));

        $user = new User($_POST['name'],$_POST['inputEmail'],$_POST['inputPassword'], $roles);

        $this->model->add($user);
        //return header("Location: index.php?controller=UserController&method=show");
        return true;
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

    public function show(){

        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location: index.php?controller=UserController&method=login');
            exit();
        }
        $row = $this->model->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->model->retrieveUserRoles($id);
        $users = $this->model->retrieveAllUsers();
        $roles = $this->model->retrieveAllUsersRoles($users);
        $name ="";
        $email = "";
        require('view/usersview.php');
    }

    public function search()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location: index.php?controller=UserController&method=login');
            exit();
        }
        if (empty($_POST)) {
            header('Location: index.php?controller=UserController&method=show');
            exit();
        }
        $row = $this->model->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->model->retrieveUserRoles($id);
        if($_POST['search']=="name") $users = $this->model->retrieveSearchedUsers("users",$_POST["search"],$_POST["value"]);
        if($_POST['search']=="email") $users = $this->model->retrieveSearchedUsers("users",$_POST["search"],$_POST["value"]);
        $roles = $this->model->retrieveAllUsersRoles($users);
        $name = "";
        #email = "";
        require('./view/usersview.php');
    }
    public function recentAdded()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location: index.php?controller=UserController&method=login');
            exit();
        }
        $row = $this->model->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->model->retrieveUserRoles($id);
        $users = $this->model->retrieveRecent("users");
        $roles = $this->model->retrieveAllUsersRoles($users);
        $name = "";
        $email = "";
        require('./view/usersview.php');
    }
    public function OlderAdded()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location: index.php?controller=UserController&method=login');
            exit();
        }
        $row = $this->model->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->model->retrieveUserRoles($id);
        $users = $this->model->retrieveOlder("users");
        $roles = $this->model->retrieveAllUsersRoles($users);
        $name = "";
        $email = "";
        require('./view/usersview.php');
    }
    public function OrderNameA()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location: index.php?controller=UserController&method=login');
            exit();
        }
        $row = $this->model->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->model->retrieveUserRoles($id);
        $users = $this->model->retrieveOrderName("users","ASC");
        $roles = $this->model->retrieveAllUsersRoles($users);
        $name = "";
        $email = "";
        require('./view/usersview.php');
    }
    public function OrderNamez()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location: index.php?controller=UserController&method=login');
            exit();
        }
        $row = $this->model->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->model->retrieveUserRoles($id);
        $users = $this->model->retrieveOrderName("users","DESC");
        $roles = $this->model->retrieveAllUsersRoles($users);
        $name = "";
        $email = "";
        require('./view/usersview.php');
    }

    public function filter()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location: index.php?controller=UserController&method=login');
            exit();
        }
        if (empty($_POST)) {
            header('Location: index.php?controller=UserController&method=show');
            exit();
        }
        $row = $this->model->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->model->retrieveUserRoles($id);

        if(isset($_POST['Recent']) || isset($_POST['Older']) || isset($_POST['A-Z']) || isset($_POST['Z-A']))
        {
            $users = $this->model->filter("users",$_POST['name'],$_POST['email']);
        }
        else
        {
            $users = $this->model->filter("users",$_POST['name'],$_POST['email']);
        }

        $roles = $this->model->retrieveAllUsersRoles($users);
        $name ="";
        $email = "";
        require('./view/usersview.php');
    }


}