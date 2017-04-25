<?php

// $A = get::multi(["bId","mode","id"]);
// print_r($A);
// $B = get::multi(["bId"=>"int","mode"=>"text","email"=>"email","url"=>"url"]);
// print_r($B);

class get extends getpost
{
	public function int ($name) {
		return getpost::get($name,getpost::filter("int"));
	}
	public function text ($name) {
		return getpost::get($name,getpost::filter("text"));
	}
	public function email ($name) {
		return getpost::get($name,getpost::filter("email"));
	}
	public function url ($name) {
		return getpost::get($name,getpost::filter("url"));
	}

	public function multi ($arg) {
		$A = array();
		foreach ($arg as $key => $value) {
			if (is_numeric($key)) {
				$A[$value] = array('filter'=>'text');
			} else {
				$A[$key]= array('filter'=>getpost::filter($value));
			}
		}
		return filter_input_array(INPUT_GET,$A);
	}
}