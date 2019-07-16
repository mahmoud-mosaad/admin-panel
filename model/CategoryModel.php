<?php

class CategoryModel
{

    public function add($name,$description)
    {
        $insert = new QueryBuilder;
        $insert->insert("category",[
            'name' => $name,
            'description'=> $description
        ]);
        header("Location: ../index.php");
    }

    public function edit($id,$name,$description)
    {
        $edit = new QueryBuilder;
        $edit->edit($id,"category",[
            'name' => $name,
            'description'=>$description
        ]);
        header("Location: ../index.php");
    }

    public function delete($id)
    {
        $delete = new QueryBuilder;
        $delete->delete("category",$id);
        header("Location: ../index.php");
    }

}