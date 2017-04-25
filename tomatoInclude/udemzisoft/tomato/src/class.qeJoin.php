<?php
namespace udemzisoft\tomato;
class qeJoin implements queryElement
{
	public function __construct ($opt) {
		$this->standby ($opt,[
			'left'=>null,	
				// tableField
			'right'=>null,
				// tableField
			'search'=>null
				// qeSearch
		]);

		$this->start();
	}
	private function start() {
	}
	public function get() {
	}
}


