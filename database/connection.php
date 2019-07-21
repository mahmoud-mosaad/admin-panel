<?php

class connection
{
    public $pdo;
	function __construct(){
 		$this->pdo = new PDO('mysql:host='.HOST.';dbname='.DBNAME,DBUSERNAME,DBPASSWORD);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}


