<?php

class User
{

    public function add($name,$email,$password)
    {
        $insert = new QueryBuilder;
        $insert->insert("users",[
            'name' => $name,
            'email' => $email,
            'password'=>$password
        ]);
        header("Location: ../index.php");
    }

    public function edit($id,$name,$email,$password)
    {
        $edit = new QueryBuilder;
        $edit->edit($id,"users",[
            'name' => $name,
            'email' => $email,
            'password'=>$password
        ]);
        header("Location: ../index.php");
    }

    public function delete($id)
    {
        $delete = new QueryBuilder;
        $delete->delete("users",$id);
        header("Location: ../index.php");
    }

}