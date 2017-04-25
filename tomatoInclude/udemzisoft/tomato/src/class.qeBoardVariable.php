<?php
namespace udemzisoft\tomato;
class qeBoardVariable implements queryElement
{
	public function __construct ($opt) {
		$this->standby ($opt,[
			'name'=>null,
			'board'=>null
		]);
	}
	public function get() {
		$name = $this->name;
		return $this->board()->$name;
	}
}