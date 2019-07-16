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

    public function insert($table , $para)
    {
        $para_name = implode(', ',array_keys($para));
        $para_value = ':' .implode(', :',array_keys($para) );
        try{
        $query = $this->pdo->prepare("insert into $table ($para_name) values ($para_value)");
        $query->execute($para);
        }catch(Exception $e){
            die('whoops, something went wrong');
        }
    }

    public function edit($id, $table , $para)
    {
        try{
        foreach ($para as $key => $value) {
            $query = $this->pdo->prepare("UPDATE $table SET $key=:key WHERE id =:id");
            $query->execute(array(
                ':id' =>$id,
                ':key' => $value
                ));
        }
        }catch(Exception $e){
            die('whoops, something went wrong');
        }
    }

    public function delete($table , $id)
    {
        $query = $this->pdo->prepare("DELETE FROM $table WHERE id=:id");
        $query->bindParam(':id',$id);
        $query->execute();
    }

}