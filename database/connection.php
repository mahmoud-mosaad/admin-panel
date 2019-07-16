<?php

class connection
{
    public $pdo;
	function __construct(){
 		$this->pdo = new PDO('mysql:host=localhost;dbname=IntCoreTaskDB','root', '');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}


