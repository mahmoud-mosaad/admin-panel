<?php
namespace app\Model;
use database\QueryBuilder;
use entity\Contact;
class ContactModel
{

    public function add()
    {
        $insert = new QueryBuilder;
        $insert->insert("contact",[
            'id' => $_REQUEST['id'],
            'phone' => $_REQUEST['phone'],
            'address'=> $_REQUEST['address']
        ]);
    }

    public function edit()
    {
        $edit = new QueryBuilder;
        $edit->edit('id',$_REQUEST['id'],"contact",[
            'phone' => $_REQUEST['phone'],
            'address'=>$_REQUEST['address']
        ]);
    }

    public function delete()
    {
        $delete = new QueryBuilder;
        $delete->delete('contact', 'id', $_REQUEST['id']);
    }

    public function retrieve() : Contact
    {
        $d = new QueryBuilder;
        $row = $d->selectcon($_REQUEST['id']);
        $cat = new Contact($row['id'], $row['phone'], $row['address']);
        return $cat;
    }
}