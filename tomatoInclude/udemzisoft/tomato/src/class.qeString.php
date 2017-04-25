<?php
namespace udemzisoft\tomato;
class qeString implements queryElement
{
	public function __construct ($opt) {
		$this->standby ($opt,[
			'string'=>null
		]);
	}
	public function get() {
		return $this->string();	
	}
}