<?php
namespace udemzisoft\tomato;
class qeRestful implements queryElement
{
	public function __construct ($opt) {
		$this->standby ($opt,[
			'name'=>null
		]);

		$this->start();
	}
	private function start() {
	}
	public function get() {
		return getpost::text($this->name());
	}
}