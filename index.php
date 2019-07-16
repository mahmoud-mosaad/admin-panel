<?php

require './controller/UsersController.php';
require './controller/CategoryController.php';

if(!isset($_GET['controller']))
{
    echo "Error 404 page not found"; die();
}
else
{
    $controller = new $_GET['controller'];
    call_user_func(array($controller, $_GET['method']));
}