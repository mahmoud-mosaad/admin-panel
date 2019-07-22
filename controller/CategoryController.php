<?php

class CategoryController extends Controller
{

    public function __construct()
    {
        parent::__construct(new CategoryModel());
    }


}