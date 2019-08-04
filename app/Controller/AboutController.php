<?php
/*
namespace app\Controller\AboutController;

use app\Model\AboutModel;
*/
class AboutController
{

    public function index()
    {
        $about = new AboutModel("about",[]);
        $abouts = $about->all();
        require_once "view/aboutview.php";
    }

    public function create()
    {
        $about = new AboutModel("about",[
            "description" => $_POST['description']
        ]);
        $about ->create();
        $abouts = $about->all();
        header("location:".BASEURL."About/index");
    }

    public function edit($id)
    {
        $about = new AboutModel("about",[
            "id" => $id,
            "description" => $_POST["description"]
        ]);
        $about->edit();
        $abouts = $about->all();
        header("location:".BASEURL."About/index");
    }

    public function delete($id)
    {
        $about = new AboutModel("about",[
            "id" => $id
        ]);
        $about->delete();
        $abouts = $about->all();
        header("location:".BASEURL."About/index");
    }
}