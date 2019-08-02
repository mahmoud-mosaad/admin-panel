<?php

require 'config/mail.php';

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct(new UserModel());
    }

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

        require 'view/register.php';
    }

    public function submit_register(){

        if ($_POST) {
            $msg = $this->check_register();
            if ($msg !== true){
                header('Location:'.BASEURL.'User/register?error='.$msg);
            }else{
                $this->save(0);

                $token = uniqid();
                $timestamp = time() + 86400 * 365 * 100; // 100 year

                $this->getModel()->addToken($token, $_POST['inputEmail'] ,date('Y-m-d H:i:s',$timestamp));

                $mail = new mail();
                $mail->setFrom(MAIL_USERNAME, MAIL_NAME);
                $mail->addAddress($_POST['inputEmail'], $_POST['name']);
                $mail->setHTMLContent('Thanks',
                    str_replace(
                        array('[:name:]', '[:verify:]'),
                        array($_POST['name'], BASEURL.'User/activate?token='.$token),
                        file_get_contents('view/Mail/registration.html')
                    )
                );
                $mail->sendMail();

                header('Location:'.BASEURL.'User/home');
                //password_hash($password, PASSWORD_DEFAULT)

            }
        }
    }

    public function activate(){
        if (isset($_GET['token'])){
            $row = $this->getModel()->retrieveAllWhere("tokens", "token", $_GET['token']);
            if ($row === false){
                header('Location:'.BASEURL.'User/login');
            }else {

                $this->getModel()->active($row[0]->email);
                $this->getModel()->deleteToken($row[0]->email);

                $_SESSION['userId'] = $row[0]->email;

                header('Location:'.BASEURL.'User/home');

            }
        }
        else{
            header('Location:'.BASEURL.'User/login?error=failed to activate email');
        }
    }

    public function check_login(){
        if (empty($_POST['inputEmail']) || empty($_POST['inputPasswordLogin'])){
            return 'All data are required ... enter the empty data';
        }

        $row = $this->getModel()->retrieveuser($_POST['inputEmail']);

        if ($row['active'] == -1){
            return 'you need to activate your account from your mail';
        }

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

        require 'view/login.php';
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
                    require 'view/resetpassword.php';
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

        if (isset($_POST['inputEmail'])
            && isset($_POST['inputPassword'])
            && isset($_POST['confirmPassword'])) {

            $row = $this->getModel()->retrieveAllWhere("tokens", "token", $_SESSION['token']);

            if ($row[0]->email != $_POST['inputEmail']){
                $msg = "That's not your mail";
                header('Location:'.BASEURL.'User/resetPassword?token='.$_SESSION['token'].'&error=' . $msg);
            }else{
                if ($_POST['inputPassword'] != $_POST['confirmPassword']) {
                    $msg = 'confirm password should equal your password';
                    header('Location:'.BASEURL.'User/resetPassword?token='. $_SESSION['token'].'&error=' . $msg);
                } else {
                    $this->getModel()->changePassword($row[0]->email, password_hash($_POST['inputPassword'], PASSWORD_DEFAULT));
                    $this->getModel()->deleteToken($row[0]->email);
                    unset($_SESSION['token']);
                    header('Location:'.BASEURL.'User/login');
                    exit();
                }
            }
        }else{
            $msg = "enter Your email and new password then confirm password";
            header('Location:'.BASEURL.'User/resetPassword?token='.$_SESSION['token'].'&error='.$msg);
        }
    }

    public function forgetPassword(){
        require 'view/forgetpassword.php';
    }

    public function submit_forgetPassword(){

        $token = uniqid();
        $timestamp = time() + 86400; // one day

        $this->getModel()->addToken($token, $_POST['inputEmail'] ,date('Y-m-d H:i:s',$timestamp));


        $mail = new mail();
        $mail->setFrom(MAIL_USERNAME, MAIL_NAME);
        $mail->addAddress($_POST['inputEmail'], $_POST['name']);
        $mail->setHTMLContent('Reset Password',
            str_replace(
                array('[:name:]', '[:reset:]'),
                array(explode("@", $_POST['inputEmail'])[0], BASEURL.'User/resetPassword?token='.$token),
                file_get_contents('view/Mail/resetpassword.html')
            )
        );
        $mail->sendMail();

        header('Location:'.BASEURL.'User/login');
    }

    public function save($value)
    {
        require 'entity/User.php';

        $roles = array();

        $roles['select'] = array(1 , ($value==0)?(0):(isset($_POST['select'])?1:0));
        $roles['create'] = array(2 , ($value==0)?(0):(isset($_POST['create'])?1:0));
        $roles['update'] = array(3 , ($value==0)?(0):(isset($_POST['update'])?1:0));
        $roles['delete'] = array(4 , ($value==0)?(0):(isset($_POST['delete'])?1:0));

        $user = new User($_POST['name'],$_POST['inputEmail'],password_hash($_POST['inputPassword'], PASSWORD_DEFAULT), $roles);

        $this->getModel()->add($user);
        //return header("Location: index.php?controller=UserController&method=show");

    }

    public function add()
    {
        require 'entity/User.php';

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
        require 'entity/User.php';

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
    }

    public function notfound(){
        require 'view/404.php';
    }

}