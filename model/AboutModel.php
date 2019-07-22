<?php

class AboutModel
{

    public function add()
    {
        $insert = new QueryBuilder;
        $insert->insert("about",[
            'id' => $_REQUEST['id'],
            'description' => $_REQUEST['description']
        ]);
    }

    public function edit()
    {
        $edit = new QueryBuilder;
        $edit->edit('id',$_REQUEST['id'],"about",[
            'description' => $_REQUEST['description']
        ]);
    }

    public function delete()
    {
        $delete = new QueryBuilder;
        $delete->delete('about', 'id', $_REQUEST['id']);
    }

    public function retrieve() : About
    {
        $d = new QueryBuilder;
        $row = $d->selectabo($_REQUEST['id']);
        $cat = new About($row['id'], $row['description']);
        return $cat;
    }
}