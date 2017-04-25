<?php
namespace udemzisoft\tomato;
class kvCache extends tomatoObject
{
	private $buffer=[];

	public function __construct () {
	}
	public function get ($key) {
		if (!$key) return false;
		return isset($this->buffer[$key])?$this->buffer[$key]:false;
	}
	public function set ($key,$value) {
		if (!$key) return ;
		$this->buffer[$key] = $value;
	}
	public function clearAll () {
		$this->buffer = [];
	}
	public function clear ($key) {
		if (!$key) return ;
		$this->buffer[$key] = null;
	}
	public function remove ($key) {
		if (!$key) return ;
		unset($this->buffer[$key]);
	}
}
