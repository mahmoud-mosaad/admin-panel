<?php

class CategoryModel
{

    public function add()
    {
        $insert = new QueryBuilder;
        $insert->insert("category",[
            'id' => $_REQUEST['id'],
            'name' => $_REQUEST['name'],
            'description'=> $_REQUEST['description']
        ]);
    }

    public function edit()
    {
        $edit = new QueryBuilder;
        $edit->edit('id',$_REQUEST['id'],"category",[
            'name' => $_REQUEST['name'],
            'description'=>$_REQUEST['description']
        ]);
    }

    public function delete()
    {
        $delete = new QueryBuilder;
        $delete->delete('category', 'id', $_REQUEST['id']);
    }

    public function retrieve() : Category
    {
        $d = new QueryBuilder;
        $row = $d->selectcat($_REQUEST['id']);
        $cat = new Category($row['id'], $row['name'], $row['description']);
        return $cat;
    }

}