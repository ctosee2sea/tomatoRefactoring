<?php
namespace udemzisoft\tomato;
class tomato extends tomatoObject implements itomato
{
	//public function start();
	public $bId;

	public function __construct($opt=null,PDO $db=null) 
	{
		if ($db) $this->db = $db;
		if ($bId) $this->bId = $bId;
	}
	public function page($bId) {

	}
	public function board($bId) {

	}
	public function action () {
	}
}