<?php

/*
namespace app\Model;

use app\database\QueryBuilder;
use app\entity\About;

require_once 'app/Model/Model.php';
*/

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
