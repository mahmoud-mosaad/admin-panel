<?php

require './controller/UsersController.php';
require './controller/CategoryController.php';

if (isset($_GET['controller'])
    && isset($_GET['method'])
    && method_exists($_GET['controller'],$_GET['method'])
    && is_callable($_GET['controller'],$_GET['method'])){

    $controller = new $_GET['controller']();
    call_user_func(array($controller,$_GET['method']));
}else{
    header('location: view/404.php');
    exit;
}
