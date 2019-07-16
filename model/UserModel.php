<?php

class UserModel
{

    public function add($name,$email,$password)
    {
        $insert = new QueryBuilder;
        $insert->insert("users",[
            'name' => $name,
            'email' => $email,
            'password'=>$password
        ]);
    }

    public function edit($id,$name,$email,$password)
    {
        $edit = new QueryBuilder;
        $edit->edit($id,"users",[
            'name' => $name,
            'email' => $email,
            'password'=>$password
        ]);
    }

    public function delete($id)
    {
        $delete = new QueryBuilder;
        $delete->delete("users",$id);
    }

    public function retrieve($table)
    {
        $select = new QueryBuilder;
        return $select->selectAll($table);
    }


}