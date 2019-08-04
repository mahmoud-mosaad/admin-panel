<?php

/*
namespace app\Model;
use app\database\QueryBuilder;
*/

class Model
{
    public function all()
    {
        $all = new QueryBuilder;
        return $all->selectAll($this->table);
    }

    public function create()
    {
        $insert = new QueryBuilder;
        foreach ($this->column as $key => $value)
        $insert->insert($this->table,[$key => $value]);

    }

    public function edit()
    {
        $edit = new QueryBuilder;
        $id=$this->column['id'][0];
        foreach ($this->column as $key => $value){
            if ($key=="id")continue;
            $edit->edit($this->id,$id,$this->table,[$key => $value]);
        }
    }


    public function delete()
    {
        $delete = new QueryBuilder;
        $id=$this->column['id'][0];
        $delete->delete($this->table, $this->id ,$id);

    }

}