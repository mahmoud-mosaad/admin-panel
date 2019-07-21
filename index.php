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
$param=[];
$controller = $url[0];
$method = $url[1];
unset($url[0]);
unset($url[1]);
$param=array_merge($param,$url);

if(isset($_GET['url'])){
    if (isset($method)
        && method_exists($controller."Controller",$method)
        && is_callable($controller."Controller",$method))
    {
        $cont = $controller."Controller";
        $cont = new $cont();
        call_user_func(array($cont,$method),$param);
    }
    else
    {
        $url = array();
        header('location:'.BASEURL.'User/notfound');
        exit;
    }

}