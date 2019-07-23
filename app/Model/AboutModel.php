<?php
namespace app\Model;
use database\QueryBuilder;
use entity\About;
class AboutModel extends Model
{
    public function __constructor()
    {
        $this->table = "about";
       // $this->
    }

    public function add()
    {
        $insert = new QueryBuilder;
        $insert->insert($this->table,[
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