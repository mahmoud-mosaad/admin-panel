<?php
/*
namespace app\Controller\CategoryController;

use app\Model\CategoryModel;
*/
class CategoryController extends Controller
{

    public function __construct()
    {
        parent::__construct(new CategoryModel());
    }


}