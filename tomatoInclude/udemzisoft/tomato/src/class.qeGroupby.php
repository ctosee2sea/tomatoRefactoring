<?php
namespace udemzisoft\tomato;
class qeGroupby implements queryElement
{
	public function __construct ($opt) {
		$this->standby ($opt,[
			'tableField'=>null
				//qeTableField
		]);

		$this->start();
	}
	private function start() {
	}
	public function get() {
		return $this->tableField()->get();
	}
}