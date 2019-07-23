<?php
namespace app\Controller;
use app\Model\AboutModel;
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