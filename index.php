<?php
session_start();
/*
require ('phpmailer/PHPMailerAutoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
*/
require './controller/UserController.php';
require './controller/CategoryController.php';
require './config.php';


$url = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));


if(isset($_GET['url'])){
    if (isset($url[1])
        && method_exists($url[0]."Controller",$url[1])
        && is_callable($url[0]."Controller",$url[1]))
    {
        $cont = $url[0]."Controller";
        $controller = new $cont();
        call_user_func(array($controller,$url[1]));
    }
    else
    {
        $url = array();
        header('location:'.$baseUrl.'User/notfound');
        exit;
    }

}