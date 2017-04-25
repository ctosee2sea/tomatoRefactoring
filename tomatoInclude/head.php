<?php
use udemzisoft\tomato as ut;


session_start();
session_cache_limiter('private');
ini_set("session.cookie_lifetime", "86400");
ini_set("session.cache_expire", "86400");
ini_set("session.gc_maxlifetime", "86400");
ini_set('display_errors', 1);

define ("ROOT_WEBDIR","");
define ("ROOT_DIR",$_SERVER["DOCUMENT_ROOT"]);
define ("TOMATO_DIR",$_SERVER["DOCUMENT_ROOT"].'/tomatoInclude');
define ("TIME_START",microtime(true));

require TOMATO_DIR.'/loader.php';
require TOMATO_DIR.'/config.php';
require TOMATO_DIR.'/func.php';

$DB = ut\db::connect([
		'type'=>DB_TYPE,
		'dbname'=>DB_NAME,
		'port'=>DB_PORT,
		'user'=>DB_USER,
		'charset'=>DB_CHARSET,
		'pass'=>DB_PASS,
		'host'=>DB_HOST
	]);
$QUICKLOAD_CACHE = new ut\kvCache();
$QUICKLOAD = new ut\quickLoad($DB);
$AUTHORITY = new ut\authority([
		"Id"=>1
	],$DB);

// $B = getpost::int("bId");
// $A = getpost::multi(["bId","mode","id"]);
// print_r($A);
// $B = getpost::multi(["bId"=>"int","mode"=>"text","email"=>"email","url"=>"url"]);
// print_r($B);
