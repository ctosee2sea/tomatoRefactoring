<?php
class getpost
{
	//public function start();

	public function int ($name) {
		return 
			isset($_GET[$name])
			?getpost::get($name,getpost::filter("int"))
			:getpost::post($name,getpost::filter("int"));
	}
	public function text ($name) {
		return 
			isset($_GET[$name])
			?getpost::get($name,getpost::filter("text"))
			:getpost::post($name,getpost::filter("text"));
	}
	public function email ($name) {
		return 
			isset($_GET[$name])
			?getpost::get($name,getpost::filter("email"))
			:getpost::post($name,getpost::filter("email"));
	}
	public function url ($name) {
		return 
			isset($_GET[$name])
			?getpost::get($name,getpost::filter("url"))
			:getpost::post($name,getpost::filter("url"));
	}

	public function multi ($arg) {
		$A = array();
		foreach ($arg as $key => $value) {
			if (is_numeric($key)) {
				$A[$value] = getpost::text($value);
			} else {
				$A[$key]= getpost::$value($key);
			}
		}
		return $A;
	}

	public function get ($name,$filter) {
		return (filter_input(INPUT_GET,$name,$filter));
	}
	public function post ($name,$filter) {
		return (filter_input(INPUT_POST,$name,$filter));
	}
	public function filter ($name) {
		switch ($name) {
			case 'int':
				return FILTER_SANITIZE_NUMBER_INT;
				break;
			
			case 'text':
				return FILTER_SANITIZE_FULL_SPECIAL_CHARS;
				break;
			
			case 'email':
				return FILTER_SANITIZE_EMAIL;
				break;
			
			case 'url':
				return FILTER_SANITIZE_URL;
				break;
			
			default:
				return FILTER_SANITIZE_FULL_SPECIAL_CHARS;
				break;
		}
	}
}