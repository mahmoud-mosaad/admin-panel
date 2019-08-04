<?php

session_start();

require_once 'loader.php';

//use app\Controller\UserController;


if (!isset($_GET['url'])){
    $url = array();
    header('location:'.BASEURL.'User/home');
    exit;
}
else {
    $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    $param = [];
    $controller = $url[0];
    $GLOBALS['controller'] = $controller;
    $method = $url[1];
    $GLOBALS['method'] = $method;
    unset($url[0]);
    unset($url[1]);
    $param = array_merge($param, $url);

    if (isset($_GET['url'])) {

        /*if (isset($method)&& method_exists("app\Controller\\".$controller . "Controller", $method)
        //    && is_callable($controller . "Controller", $method)
        )*/

        if (isset($method)
            && method_exists($controller . "Controller", $method)
        ){


            $cont = $controller . "Controller";
            //$cont = "app\Controller\\".$controller . "Controller";

            $cont = new $cont();

            call_user_func(array($cont, $method), $param);
        }
        else {
            $url = array();
            header('location:' . BASEURL . 'User/notfound');
            //$url = array();echo "$method";
            //header('location:' . BASEURL . 'User/notfound');
            exit;
        }

    }
}

