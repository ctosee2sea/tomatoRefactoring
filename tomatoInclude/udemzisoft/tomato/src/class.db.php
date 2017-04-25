<?php
namespace udemzisoft\tomato;
class db extends tomatoObject
{
	public function connect ($opt) {

		// 'type'=>DB_TYPE,
		// 'dbname'=>DB_NAME,
		// 'port'=>DB_PORT,
		// 'user'=>DB_USER,
		// 'charset'=>DB_CHARSET,
		// 'pass'=>DB_PASS,
		// 'host'=>DB_HOST

		$connect = new \PDO(
			sprintf(
				'%s:host=%s;dbname=%s;port=%s;charset=%s',
				$opt['type'],
				$opt['host'],
				$opt['dbname'],
				$opt['port'],
				$opt['charset']
			),
			$opt['user'],
			$opt['pass']
		);
		// $connect = mysql_connect($opt['host'],$opt['user'],$opt['pass']);

		if ($connect) {
			// echo 'ok';
		} else {
			$this->unconnect();
		}

		// mysql_query("set names utf8");
		// mysql_select_db($opt['dbname'],$connect);

		return $connect;
		// return $connect;
	}
	private function unconnect() {
		echo '접속 에러';
	}
}