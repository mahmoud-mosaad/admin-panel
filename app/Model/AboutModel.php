<?php
namespace app\Model;
use database\QueryBuilder;
use entity\About;
class AboutModel extends Model
{

    protected $table ;

    protected $column = [];

    protected $id;

    public function __construct($table,$column)
    {
        $this->table = $table ;
        $this->column = $column ;
        $this->id ='id';
    }

}
