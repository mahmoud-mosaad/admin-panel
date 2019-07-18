<?php

require './database/connection.php';
class QueryBuilder extends connection
{

    public function selectAll($table)
    {
        $query = $this->pdo->prepare("select * from {$table}");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectUsers()
    {
        $query = $this->pdo->prepare("select * from users");
        $query->execute();
        return $users = $query->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectUsersRoles($users){

        $roles = array();

        foreach ($users as $user){

            $roles_m = $this->selectUserRoles($user->id);

            foreach($roles_m as $role_m){
                if($role_m->role_id == 1)
                    $roles[$user->id]['select'] = $role_m->auth ;
                else if($role_m->role_id == 2)
                    $roles[$user->id]['create'] = $role_m->auth ;
                else if($role_m->role_id == 3)
                    $roles[$user->id]['update'] = $role_m->auth ;
                else if($role_m->role_id == 4)
                    $roles[$user->id]['delete'] = $role_m->auth ;
            }

        }
        return $roles;
    }

    public function selectUserRoles($id)
    {
        $query = $this->pdo->prepare("select role_id,auth from user_roles where user_id =:user_id");
        $query->bindValue(':user_id', $id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectuser($email)
    {
        $query = $this->pdo->prepare("select * from users where email=:email");
        $query->bindValue(':email', $email);
        $query->execute();
        if ($query->rowCount() <= 0 ){
            return false;
        }
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function selectid($email)
    {
        $query = $this->pdo->prepare("select id from users where email=:email");
        $query->bindValue(':email', $email);
        $query->execute();
        if ($query->rowCount() <= 0 ){
            return false;
        }
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table , $para)
    {
        $para_name = implode(', ',array_keys($para));
        $para_value = ':'.implode(', :',array_keys($para) );
        try{
            $query = $this->pdo->prepare("insert into $table ($para_name) values ($para_value)");
            foreach ($para as $key => $value){
                $query->bindValue($key, $value);
            }
            $query->execute();
        }catch(Exception $e){
            die('whoops, something went wrong');
        }
    }

    public function edit($column, $id, $table , $para)
    {
        try{
            foreach ($para as $key => $value) {
                $query = $this->pdo->prepare("UPDATE $table SET $key=:key WHERE $column =:$column");
                $query->bindValue(':key',$value);
                $query->bindValue(':'.$column,$id);
                $query->execute();
            }
        }catch(Exception $e){
            die('whoops, something went wrong');
        }
    }

    public function editRoles($column, $v, $column2, $id, $table , $para)
    {
        try{
            foreach ($para as $key => $value) {
                $query = $this->pdo->prepare("UPDATE $table SET $key=:$key WHERE $column =:$column and $column2 =:$column2");
                $query->bindValue(':'.$key,$value);
                $query->bindValue(':'.$column,$v);
                $query->bindValue(':'.$column2,$id);
                $query->execute();
            }
        }catch(Exception $e){
            die('whoops, something went wrong');
        }
    }

     public function search($table ,$category, $value)
     {
        $query = $this->pdo->prepare("select * from {$table} where {$category} like '$value%'");
        //$query->bindValue(':'.$category, $value);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
     }



    public function delete($table , $column , $id)
    {
        $query = $this->pdo->prepare("DELETE FROM $table WHERE $column=:$column");
        $query->bindParam(':'.$column,$id);
        $query->execute();
    }

    public function Recent($table)
    {

        $query = $this->pdo->prepare("SELECT * FROM {$table} ORDER BY id DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
    }
    public function Older($table)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$table} ORDER BY id ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
    }
    public function OrderByName($table,$order)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$table} ORDER BY name $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
    }



    public function filter($table,$name,$email)
    {
        if(isset($_POST['Recent']))
        {
            if(strlen($name) && strlen($email))
                {
                    $query = $this->pdo->prepare("select * from {$table} where name like '$name%' AND email like '$email%' ORDER BY id DESC");
                }
                if(!strlen($name) && strlen($email))
                {
                    $query = $this->pdo->prepare("select * from {$table} where email like '$email%' ORDER BY id DESC");
                }
                if(strlen($name) && !strlen($email))
                {
                    $query = $this->pdo->prepare("select * from {$table} where name like '$name%' ORDER BY id DESC");
                }
                if(!strlen($name) && !strlen($email))
                {
                    $query = $this->pdo->prepare("select * from {$table} ORDER BY id DESC ");
                }
                $query->execute();
                return $query->fetchAll(PDO::FETCH_CLASS);
        }
        if(isset($_POST['Older']))
        {
            if(strlen($name) && strlen($email))
                {
                    $query = $this->pdo->prepare("select * from {$table} where name like '$name%' AND email like '$email%' ORDER BY id ASC");
                }
                if(!strlen($name) && strlen($email))
                {
                    $query = $this->pdo->prepare("select * from {$table} where email like '$email%' ORDER BY id ASC");
                }
                if(strlen($name) && !strlen($email))
                {
                    $query = $this->pdo->prepare("select * from {$table} where name like '$name%' ORDER BY id ASC");
                }
                if(!strlen($name) && !strlen($email))
                {
                    $query = $this->pdo->prepare("select * from {$table} ORDER BY id ASC ");
                }
                $query->execute();
                return $query->fetchAll(PDO::FETCH_CLASS);
        }
        if(isset($_POST['A-Z']))
        {
                $query = $this->pdo->prepare("SELECT * FROM {$table} where name like '$name%' ORDER BY name ASC");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_CLASS);
        }
        if(isset($_POST['Z-A']))
        {
                $query = $this->pdo->prepare("SELECT * FROM {$table} where name like '$name%' ORDER BY name DESC");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_CLASS);
        }
        else
        {
            if(strlen($name) && strlen($email))
            {
                $query = $this->pdo->prepare("select * from {$table} where name like '$name%' AND email like '$email%'");
            }
            if(!strlen($name) && strlen($email))
            {
                $query = $this->pdo->prepare("select * from {$table} where email like '$email%' ");
            }
            if(strlen($name) && !strlen($email))
            {
                $query = $this->pdo->prepare("select * from {$table} where name like '$name%' ");
            }
            if(!strlen($name) && !strlen($email))
            {
                $query = $this->pdo->prepare("select * from {$table} ");
            }
            $query->execute();
            return $query->fetchAll(PDO::FETCH_CLASS);
        }

    }
}