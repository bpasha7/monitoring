<?php
class Database extends PDO
{
	public function __construct($user='banned', $password)
	{
		parent::__construct("mysql:host=localhost;dbname=monitoring;charset=utf8", "root", "");
		$this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		//header('Content-type: application/json; charset=utf-8');

		//$db = new PDO('mysql:host=127.0.0.1;dbname=auction;charset=utf8', 'root', 'qwerty');
		//(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	}
}
?>