<?php
function p ($msg) {
	udemzisoft\tomato\system::p($msg);
}

function ql ($table,$colum,$var,$deleted=0,$new=0,$DB=null) {
	return $GLOBALS["QUICKLOAD"]->ql($table,$colum,$var,$deleted,$new);
}

function qls ($table,$colum,$var,$deleted=0,$new=0,$DB=null) {
	return $GLOBALS["QUICKLOAD"]->qls($table,$colum,$var,$deleted,$new);
}

function alert ($msg,$opt) {
	udemzisoft\tomato\system::alert($msg,$opt);
}
function stop ($msg,$opt) {
	$opt['stop']=true;
	udemzisoft\tomato\system::alert($msg,$opt);
}
function goBack ($msg,$opt) {
	$opt['stop']=true;
	$opt['history']=-1;
	udemzisoft\tomato\system::alert($msg,$opt);
}