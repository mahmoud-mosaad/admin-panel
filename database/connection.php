<?php

class connection
{
    public $pdo;
	function __construct(){
 		$this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=task1','root', '');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}


