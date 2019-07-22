<?php

class Controller
{

    private $model;
    public function __construct($modl)
    {
        $this->model = $modl;
    }

    public function add(){
        require 'view/'.$GLOBALS['controller'].'/add.php';
    }

    public function create(){
        $this->getModel()->add();
    }

    public function edit(){
        require 'view/'.$GLOBALS['controller'].'/edit.php';
    }

    public function update(){
        $this->getModel()->edit();
    }

    public function delete(){
        require 'view/'.$GLOBALS['controller'].'/delete.php';
    }

    public function remove(){
        $this->getModel()->delete();
    }

    public function retrieve(){
        $data = $this->getModel()->retrieve();
        require 'view/'.$GLOBALS['controller'].'/retrieve.php';
    }
/*
     private function getObjectAttributes($my_class){
        $vars = array();
        $class_methods = get_class_methods($my_class);
        foreach ($class_methods as $method_name)
        {
            if (substr( $method_name, 0, 3 ) === "get"){
                if (method_exists($my_class, $method_name)
                    && is_callable(array($my_class, $method_name))
                ) {
                    $vars[strtolower(substr( $method_name, 3, strlen($method_name)))] =
                        call_user_func(array($my_class, $method_name));
                }
            }
        }
        return $vars;
    }
*/

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }



}