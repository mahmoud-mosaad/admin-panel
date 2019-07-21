<?php
/**
 * Created by PhpStorm.
 * User: mahmo
 * Date: 7/21/2019
 * Time: 2:52 PM
 */

class Controller
{

    private $model;
    public function __construct($modl)
    {
        $this->model = $modl;
    }

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