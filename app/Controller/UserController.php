<?php
namespace app\Controller;

use  app\Model\UserModel;
use entity\User;
class UserController  extends Controller
{
    public function __construct()
    {
        parent::__construct(new UserModel());
    }

    /*
    function sendMail(){
        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'my e-mail';                 // SMTP username
        $mail->Password = 'my password';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
    }*/

    function setCookies($email){
        $exp = time() + (60*60*24*30*12); // 1 Hour
        setcookie("userId", $email, $exp);
        $row = $this->getModel()->retrieveuser($email);
        setcookie("userP", $row['password'], $exp);
    }

    function checkCookies(){
        if (isset($_COOKIE['userId'])){
            $row = $this->getModel()->retrieveuser($_COOKIE['userId']);
            if ($row != false && $_COOKIE['userP'] === $row['password']){
                $_SESSION['userId'] = $_COOKIE['userId'];
                header('Location:'.BASEURL.'User/home');
                exit();
            }
        }
    }

    public function checkSession() {
        //if user has login and session has not been removed
        if(isset($_SESSION['userId']))
        {
            //logged in so redirect
            header('Location:'.BASEURL.'User/home');
            exit();
        }
    }

    public function logout() {
        unset($_SESSION['userId']);
        session_destroy();
        setcookie("userId", NULL, time() - 600);
        setcookie("userP", NULL, time() - 600);
        header("location:".BASEURL."User/login");
        exit();
    }

    public function check_create_user(){

        $arr = array();

        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirmpassword'])){

            $arr['name'] = (empty($_POST['name'])? 'name required': '');
            $arr['email'] = (empty($_POST['email'])? 'email required': '');
            $arr['password'] = (empty($_POST['password'])? 'password required': '');
            $arr['confirmpassword'] = (empty($_POST['confirmpassword'])? 'confirm password required': '');
            $myJSON = json_encode($arr);

            echo $myJSON;
        }
        else{
            $row = $this->getModel()->retrieve($_POST['email']);
            if ($row == false){
                if ($_POST['password'] != $_POST['confirmpassword']){
                    $arr['password'] =  'confirm password should equal your password';
                    $myJSON = json_encode($arr);
                    echo $myJSON;
                }else{
                    echo true;
                }
            }else{
                // repeated email
                $arr['email'] = 'This email is already registered';
                $myJSON = json_encode($arr);
                echo $myJSON;
            }
        }
    }

    public function check_edit_user()
    {

        if (empty($_POST['name']) && empty($_POST['email'])){
            echo 'All data are required ... enter the empty data';
        }else if (empty($_POST['name']) || empty($_POST['email'])){

            $arr = array('name' => empty($_POST['name']),
                'email' => empty($_POST['email'])
            );

            $error = '';
            $first = true;
            foreach($arr as $key => $value){
                if ($value == true){
                    $error.= ($first == true ?$key : ','.$key);
                    $first = false;
                }
            }

            echo $error . ' should be entered';
        }else {

            $row = $this->getModel()->retrieveemail($_POST['id']);
            if ($row['email'] !== $_POST['email']) {
                $row = $this->getModel()->retrieve($_POST['email']);
                if ($row == false) {
                    echo true;
                } else {
                    // repeated email
                    echo 'This email is already registered';
                }
            } else {
                echo true;
            }
        }
    }

    public function check_register(){

        if (empty($_POST['name']) || empty($_POST['inputEmail']) || empty($_POST['inputPassword'])){
            return 'All data are required ... enter the empty data';
        }
        $row = $this->getModel()->retrieve($_POST['inputEmail']);
        if ($row == false){

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

        //require 'view/register.php';
        $this->view('register');
    }

    public function submit_register(){

        if ($_POST) {
            $msg = $this->check_register();
            if ($msg !== true){
                header('Location:'.BASEURL.'User/register?error='.$msg);
            }else{
                $this->save(0);
                $_SESSION['userId'] = $_POST['inputEmail'];
                $to_mail = $_POST['inputEmail'];
                $subject = "Thanks";
                $msg = "Dear " . $_POST['name'] . " ... Thanks for registration in admin-panel";
                mail($to_mail, $subject, $msg);

                header('Location:'.BASEURL.'User/home');
                //password_hash($password, PASSWORD_DEFAULT)

            }
        }
    }

    public function check_login(){
        if (empty($_POST['inputEmail']) || empty($_POST['inputPasswordLogin'])){
            return 'All data are required ... enter the empty data';
        }

        $row = $this->getModel()->retrieveuser($_POST['inputEmail']);

        if ($row !== false){

            //checked username and password
            //if (password_verify($password, $row['password'])){
            if (password_verify($_POST['inputPasswordLogin'], $row['password'])){
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

        $this->view('login');
    }

    public function submit_login(){
        if (!empty($_POST)){

            $msg = $this->check_login();

            if ($msg !== true){
                header('Location:'.BASEURL.'User/login?error='.$msg);
            }else{
                if (isset($_POST['rememberme'])){
                    $this->setCookies($_POST['inputEmail']);
                }
                header('Location:'.BASEURL.'User/home');
                exit();
            }

        }
    }

    public function resetPassword(){
        if (isset($_GET['token'])){
            $row = $this->getModel()->retrieveAllWhere("tokens", "token", $_GET['token']);
            if ($row === false){
                header('Location:'.BASEURL.'User/login');
            }else {
                $time = time();
                if (strtotime($row[0]->expire) > $time) {
                    $_SESSION['token'] = $_GET['token'];
                    //require 'view/resetpassword.php';
                    $this->view('resetpassword');
                }
                else{
                    header('Location:'.BASEURL.'User/login');
                }
            }
        }
        else{
            header('Location:'.BASEURL.'User/login?error=there is no token');
        }

    }

    public function submit_resetPassword(){

        if (isset($_POST['inputEmail'])) {
            $row = $this->getModel()->retrieveAllWhere("tokens", "email", $_POST['inputEmail']);
            if ($row['email'] != $_POST['inputEmail']){
                $msg = "That's not your mail";
                header('Location:'.BASEURL.'User/resetPassword?error=' . $msg);
            }else{
                if (isset($_POST['inputPassword']) && isset($_POST['confirmPassword'])
                    && $_POST['inputPassword'] != $_POST['confirmPassword']) {
                    $msg = 'confirm password should equal your password';
                    header('Location:'.BASEURL.'User/resetPassword?error=' . $msg);
                } else {

                    $row = $this->getModel()->retrieveAllWhere("tokens", "token", $_SESSION['token']);

                    $this->getModel()->changePassword($row[0]->email, password_hash($_POST['inputPassword'], PASSWORD_DEFAULT));

                    $this->getModel()->deleteToken($row[0]->email);
                    unset($_SESSION['token']);
                    header('Location:'.BASEURL.'User/login');
                    exit();
                }
            }
        }else{
            $msg = "enter Your email";
            header('Location:'.BASEURL.'User/resetPassword?error='.$msg);
        }
    }

    public function forgetPassword(){
        //require 'view/forgetpassword.php';
        $this->view('forgetpassword');
    }

    public function submit_forgetPassword(){

        $token = uniqid();
        $timestamp = time() + 86400;

        $this->getModel()->addToken($token, $_POST['inputEmail'] ,date('Y-m-d H:i:s',$timestamp));


        $to_mail = $_POST['inputEmail'];
        $subject = "admin-panel";
        $msg = " <a class=\"d-block small\" href=\"" .BASEURL.'User/resetPassword?token='.$token."\">reset Password</a>";
        $headers = "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to_mail, $subject, $msg, $headers);

        header('Location:'.BASEURL.'User/login');
    }

    public function save($value)
    {
        //require 'entity/User.php';
        


        $roles = array();

        $roles['select'] = array(1 , ($value==0)?(0):(isset($_POST['select'])?1:0));
        $roles['create'] = array(2 , ($value==0)?(0):(isset($_POST['create'])?1:0));
        $roles['update'] = array(3 , ($value==0)?(0):(isset($_POST['update'])?1:0));
        $roles['delete'] = array(4 , ($value==0)?(0):(isset($_POST['delete'])?1:0));

        $user = new User($_POST['name'],$_POST['inputEmail'],password_hash($_POST['inputPassword'], PASSWORD_DEFAULT), $roles);

        $this->getModel()->add($user);
        //return header("Location: index.php?controller=UserController&method=show");

    }

    public function add()//$value)
    {
        //require 'entity/User.php';
        

        $roles = array();

        $roles['select'] = array(1 , $_POST['select'] == 'true' ? 1 : 0);
        $roles['create'] = array(2 , $_POST['create'] == 'true' ? 1 : 0);
        $roles['update'] = array(3 , $_POST['update'] == 'true' ? 1 : 0);
        $roles['delete'] = array(4 , $_POST['delete'] == 'true' ? 1 : 0);

        $user = new User($_POST['name'],$_POST['inputEmail'],password_hash($_POST['inputPassword'], PASSWORD_DEFAULT), $roles);

        if ($_POST['inputPassword'] == $_POST['confirmPassword']) {
            $this->getModel()->add($user);
        }
        //return header("Location: index.php?controller=UserController&method=show");

    }

    public function edit()
    {
        //require 'entity/User.php';
        

        $roles = array();
                                    // isset before
        $roles['select'] = array(1 , $_POST['select'] == 'true' ? 1 : 0);
        $roles['create'] = array(2 , $_POST['create'] == 'true' ? 1 : 0);
        $roles['update'] = array(3 , $_POST['update'] == 'true' ? 1 : 0);
        $roles['delete'] = array(4 , $_POST['delete'] == 'true' ? 1 : 0);


//        $user = new User($_POST['name'],$_POST['email'],$_POST['password'], $roles);
        $user = new User($_POST['name'],$_POST['email'], '', $roles);

        $this->getModel()->edit($user,$_GET['edit']);
        //return header("Location: index.php?controller=UserController&method=show");
    }

    public function delete()
    {
        $this->getModel()->delete($_GET['delete']);

        //$this->getModel()->delete(7);
        //return header("Location: index.php?controller=UserController&method=show");
    }

    public function home(){

        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location:'.BASEURL.'User/login');
            exit();
        }

        $row = $this->getModel()->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->getModel()->retrieveUserRoles($id);
        $users = $this->getModel()->retrieveAllUsers();
        $roles = $this->getModel()->retrieveAllUsersRoles($users);
        $name= "";
        $email = "";
    require('view/home.php');
        //$this->view('home');
    }

    public function show()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location:'.BASEURL.'User/login');
            exit();
        }
        $row = $this->getModel()->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->getModel()->retrieveUserRoles($id);
        $users = $this->getModel()->retrieveAllUsers();
        $roles = $this->getModel()->retrieveAllUsersRoles($users);
        $name ="";
        $email = "";
        require('view/dashboard.php');
        //$this->view('dashboard');
    }

    public function search()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location:'.BASEURL.'User/login');
            exit();
        }
        if (empty($_POST)) {
            header('Location:'.BASEURL.'User/show');
            exit();
        }
        $row = $this->getModel()->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->getModel()->retrieveUserRoles($id);
        if($_POST['search']=="name") $users = $this->getModel()->retrieveSearchedUsers("users",$_POST["search"],$_POST["value"]);
        if($_POST['search']=="email") $users = $this->getModel()->retrieveSearchedUsers("users",$_POST["search"],$_POST["value"]);
        $roles = $this->getModel()->retrieveAllUsersRoles($users);
        $name = "";
        #email = "";
        require('./view/dashboard.php');
        //$this->view('dashboard');
    }
    public function recentAdded()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location:'.BASEURL.'User/login');
            exit();
        }
        $row = $this->getModel()->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->getModel()->retrieveUserRoles($id);
        $users = $this->getModel()->retrieveRecent("users");
        $roles = $this->getModel()->retrieveAllUsersRoles($users);
        $name = "";
        $email = "";
        require('./view/dashboard.php');
        //$this->view('dashboard');
    }

    public function OlderAdded()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location:'.BASEURL.'User/login');
            exit();
        }
        $row = $this->getModel()->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->getModel()->retrieveUserRoles($id);
        $users = $this->getModel()->retrieveOlder("users");
        $roles = $this->getModel()->retrieveAllUsersRoles($users);
        $name = "";
        $email = "";
        require('./view/dashboard.php');
        //$this->view('dashboard');
    }

    public function OrderNameA()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location:'.BASEURL.'User/login');
            exit();
        }
        $row = $this->getModel()->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->getModel()->retrieveUserRoles($id);
        $users = $this->getModel()->retrieveOrderName("users","ASC");
        $roles = $this->getModel()->retrieveAllUsersRoles($users);
        $name = "";
        $email = "";
        require('./view/dashboard.php');
        //$this->view('dashboard');
    }

    public function OrderNamez()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location:'.BASEURL.'User/login');
            exit();
        }
        $row = $this->getModel()->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->getModel()->retrieveUserRoles($id);
        $users = $this->getModel()->retrieveOrderName("users","DESC");
        $roles = $this->getModel()->retrieveAllUsersRoles($users);
        $name = "";
        $email = "";
        require('./view/dashboard.php');
        //$this->view('dashboard');
    }

    public function filter()
    {
        if(!isset($_SESSION['userId'])){
            // not logged in
            header('Location:'.BASEURL.'User/login');
            exit();
        }
        if (empty($_POST)) {
            header('Location:'.BASEURL.'User/show');
            exit();
        }
        $row = $this->getModel()->retrieve($_SESSION['userId']);
        $id = $row['id'];
        $userRoles = $this->getModel()->retrieveUserRoles($id);

        if(isset($_POST['Recent']) || isset($_POST['Older']) || isset($_POST['A-Z']) || isset($_POST['Z-A']))
        {
            $users = $this->getModel()->filter("users",$_POST['name'],$_POST['email']);
        }
        else
        {
            $users = $this->getModel()->filter("users",$_POST['name'],$_POST['email']);
        }

        $roles = $this->getModel()->retrieveAllUsersRoles($users);
        $name ="";
        $email = "";
        require('./view/dashboard.php');
        //$this->view('dashboard');
    }

    public function notfound(){
        require 'view/404.php';
        //$this->view('404');
    }


}