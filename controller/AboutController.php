<?php

class AboutController extends Controller
{

    public function __construct()
    {
        parent::__construct(new AboutModel());
    }

    public  function add()
    {
        AboutModel::add();
    }


}