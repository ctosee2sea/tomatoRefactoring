<?php
//Config.php

//Make Variables : need setting in first time

// DB cunnect Information

date_default_timezone_set('Asia/Seoul');

define("DB_TYPE", "mysql");
define("DB_HOST", "127.0.0.1");
define("DB_PORT", "3306"); //175.126.111.101
define("DB_USER", "tr");
define("DB_PASS", "udmz0518");
define("DB_NAME", "tr");
define("DB_CHARSET", "utf8");

// define ("BASE_URL","http://archives.knowhow.or.kr");
// define ("BASE_URL_FILE","http://file3.knowhow.or.kr");
// define ("BASE_URL_MOBILE","http://archives.knowhow.or.kr/m");

//Site Variables : mode
// lunching
// debug
//
define("MODE", "lunching");

if (MODE=="debug") {
    $account1 = 1;
    session_register("account");
    define("account", "1,38");
} else {
    $account1 = "39,38";
}
//Site Variables : system and admin information

define("DEVELOPER_EMAIL", "esil@tinkl.com");

//Site Variables : etc
$siteTitle = ":::: 관리자 ::::";

//login Information

//Make Variables :: fixed

//for debug
$fileinfoLoopMax = 500;
    //setting number "bigger then count all file" what regsted by sitemap, for "block intinite loop" by finding file in siteMap
    //siteMap에서 파일을 찾기 위해 무한 루프 되는 것을 막기 위해, siteMap에 등록된 파일보다 큰 숫자를 등록한다.

//session load
if (isset($_SESSION["trtp_login_id"])) {
    $trtp_login_identity = @$_SESSION["trtp_login_identity"];
    $trtp_login_time = @$_SESSION["trtp_login_time"];
    $trtp_login_ip = @$_SESSION["trtp_login_ip"];
    $account1 = @$_SESSION["trtp_account"].",38";
    $trtp_account = @$_SESSION["trtp_account"];
    $trtp_login_id = @$_SESSION["trtp_login_id"];
} else {
    $trtp_login_identity = "";
    $trtp_login_id = "";
}
if (!$account1) {
    $account1 = "38,39";
    $_SESSION["trtp_account"] = $account1.",38";
}
define("account", $account1);
define("loginIdentity", $trtp_login_identity);
define("loginId", $trtp_login_id);
if (!isset($_SESSION["debug_mode"])) {
    $_SESSION["debug_mode"] = false;
}
define("debugMode", $_SESSION["debug_mode"]);




//client


$mobileKeyWords = array('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'Windows CE;', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson', 'Mobile', 'Symbian', 'Opera Mobi', 'Opera Mini', 'IEmobile');
// p ($_SERVER['HTTP_USER_AGENT']);
// p ($_SERVER['REQUEST_URI']);
foreach ($mobileKeyWords as $value) {
    if (strpos($_SERVER['HTTP_USER_AGENT'], $value) == true&&!strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
        define('mobileClient', '1');
    }
}




//echo $trtp_login_id;
//echo $account1;
// load pear pakage


//Table List

//ETC Common Data
define("siteMapTable", "etc_bs_sitemap");
$siteMapTable = siteMapTable;
define("logTable", "etc_bs_log");
$logTable = logTable;
define("messageTable", "etc_bs_message");
$messageTable = messageTable;

//ETC Skin Manager Data
define("skinTable", "etc_bs_siteskin");
$skinTable = skinTable;

//ETC Basic Data
define("memberTable", "etc_bs_member");
$memberTable = memberTable;
define("zipcode", "zipcode");
$zipcode = zipcode;


    //구조체


//1차 개발 : 유동적인 형태의 게시판. 기본 스킨으로 db만 조정하여 제작할 수 있는 게시판

//2차 개발 : 상세 작업
    // 각각의 필드에 사용 권한 적용
//3차 개발 : cms 개발툴의 역할. 최적화된 보드 export
    //

//SiteMap parent = 0, order = n
$homeSiteMapOrder =1;

//UploadPath, Link
$uploadPath =ROOT_DIR."/../upload/";
define("uploadPath", $uploadPath);
$uploadLink ="upload/";
define("uploadLink", $uploadLink);


//몇가지 접미사 약속어
/*
E : element
D : data
Q : query
A : array
C : character (같은 접두사의 다른 것이 없다면 생략 가능)
N : num_rows (개수)
*/
// dbgMsg ("config.php",0,0);


// $adminLogin=1;
